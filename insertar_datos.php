<?php
// Verificar si la solicitud es de tipo PUT
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Establecer la conexión con la base de datos
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los datos enviados por el dispositivo Arduino mediante PUT
    $putData = file_get_contents("php://input");
    parse_str($putData, $datos);

    // Asignar los datos a variables
    $movimiento = $datos['movimiento'] ?? '';
    $temperatura = $datos['temperatura'] ?? '';
    $humedad = $datos['humedad'] ?? '';
    $hora = $datos['hora'] ?? '';
    $esDeDia = $datos['es_de_dia'] ?? '';

    // Preparar la consulta SQL para actualizar los datos en la tabla
    $sql = "UPDATE mediciones SET temperatura='$temperatura', humedad='$humedad', hora='$hora', es_de_dia='$esDeDia' WHERE movimiento='$movimiento'";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        echo "Datos actualizados correctamente";
    } else {
        echo "Error al actualizar datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si la solicitud no es de tipo PUT, mostrar un mensaje de error
    echo "Error: Se esperaba una solicitud PUT";
}
