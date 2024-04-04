#include <Arduino.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <DHT.h>
#include <WiFi.h>
#include <NTPClient.h>
#include <WiFiUdp.h>
#include <HTTPClient.h>

#define SCREEN_WIDTH 128 // Ancho de la pantalla OLED en píxeles
#define SCREEN_HEIGHT 64 // Alto de la pantalla OLED en píxeles
#define OLED_RESET -1

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

#define PIR_PIN 15  // Pin del sensor de movimiento
#define DHT_PIN 4   // Pin del sensor DHT11
#define LDR_PIN 34  // Pin del sensor de luz (LDR)

#define DHTTYPE DHT11
DHT dht(DHT_PIN, DHTTYPE);

const char* ssid = "STW-Students";
const char* password = "mEGThJyUW3xP";

WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org");

const char* serverAddress = "http://10.100.138.14:3000/insertar_datos.php"; // Reemplaza con tu dirección de servidor PHP

void setup() {
  Serial.begin(115200);

  if (!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("Error al iniciar SSD1306 OLED"));
    while (true);
  }
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);

  dht.begin();
  pinMode(PIR_PIN, INPUT);
  pinMode(LDR_PIN, INPUT);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }
  
  timeClient.begin();
  timeClient.setTimeOffset(3600);  // GMT+1
}

void loop() {
  timeClient.update();
  int hour = timeClient.getHours();
  int minute = timeClient.getMinutes();
  
  // Sumar una hora
  hour++;
  if (hour > 23) {
    hour = 0; // Si supera 23, resetear a 0
  }

  int movimiento = digitalRead(PIR_PIN);
  float temperatura = dht.readTemperature();
  float humedad = dht.readHumidity();
  int luz = analogRead(LDR_PIN);
  bool esDeDia = (luz > 512);

  // Mostrar mediciones en la pantalla OLED
  display.clearDisplay();
  display.setCursor(0, 0);
  display.println(movimiento ? "Movimiento detectado" : "Sin movimiento");

  display.setCursor(0, 10);
  display.print("Temperatura: ");
  display.print(temperatura);
  display.println(" C");

  display.setCursor(0, 20);
  display.print("Humedad: ");
  display.print(humedad);
  display.println(" %");

  display.setCursor(0, 30);
  display.print("Hora: ");
  char timeBuffer[8]; // Buffer para almacenar la hora formateada
  sprintf(timeBuffer, "%02d:%02d", hour, minute); // Formatear hora y minutos con dos dígitos
  display.print(timeBuffer);

  if (esDeDia) {
    // Dibujar sol en la esquina derecha
    display.fillCircle(120, 48, 8, SSD1306_WHITE); // Dibujar un círculo blanco más grande
    display.drawCircle(120, 48, 8, SSD1306_WHITE); // Contorno del círculo
    display.drawPixel(120, 48, SSD1306_BLACK); // Punto negro en el centro
  } else {
    // Dibujar luna en la esquina derecha
    display.fillCircle(120, 48, 6, SSD1306_WHITE); // Dibujar un círculo blanco más pequeño
    display.drawCircle(120, 48, 6, SSD1306_WHITE); // Contorno del círculo
  }

  display.display();

  // Enviar mediciones a la base de datos mediante una solicitud HTTP PUT
  HTTPClient http;
  http.begin(serverAddress);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  // Construir el cuerpo de la solicitud PUT con los datos de las mediciones
  String putData = "movimiento=" + String(movimiento) +
                    "&temperatura=" + String(temperatura) +
                    "&humedad=" + String(humedad) +
                    "&hora=" + String(hour) + ":" + String(minute) +
                    "&es_de_dia=" + String(esDeDia);

  int httpResponseCode = http.PUT(putData);

  if (httpResponseCode > 0) {
    Serial.print("Solicitud PUT exitosa. Código de respuesta HTTP: ");
    Serial.println(httpResponseCode);
  } else {
    Serial.print("Error en la solicitud PUT. Código de error HTTP: ");
    Serial.println(httpResponseCode);
  }

  http.end();

  delay(1000);
}
