<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitación</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="icon" href="house.png" type="image/x-icon">
</head>

<body>
    <div class="titulo">Habitación<span class="subtitulo">Erlangen, Alemania</span></div>

    <div class="container">
        <div class="item f1">
            <div class="widget hora">
                <?php
                // Conectar a la base de datos
                $servername = "";
                $username = "";
                $password = "";
                $dbname = "";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Seleccionar la última hora de la base de datos
                $sql = "SELECT hora FROM mediciones ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo substr($row["hora"], 0, 5);
                    }
                } else {
                    echo "No se encontraron datos";
                }

                $conn->close();
                ?>
            </div>
            <div class="widget luz"><img class="icono_luz" src="moon.svg" alt="Icono día"></div>
        </div>
        <!-- Segunda fila -->
        <div class="item f2">
            <div class="widget tem">
                <div class="titulo_dato">Temperatura</div>
                <div class="info">
                    <?php
                    // Conectar a la base de datos (repetido para cada dato)
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Seleccionar la última temperatura de la base de datos
                    $sql = "SELECT temperatura FROM mediciones ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo $row["temperatura"];
                        }
                    } else {
                        echo "No se encontraron datos";
                    }

                    $conn->close();
                    ?>
                    °
                    <img class="icono_tem" src="temperature.svg" alt="Icono temperatura">
                </div>
            </div>
            <div class="widget tem">
                <div class="titulo_dato">Humedad</div>
                <div class="info">
                    <?php
                    // Conectar a la base de datos (repetido para cada dato)
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Seleccionar la última humedad de la base de datos
                    $sql = "SELECT humedad FROM mediciones ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo $row["humedad"];
                        }
                    } else {
                        echo "No se encontraron datos";
                    }

                    $conn->close();
                    ?>
                    <img class="icono_tem" src="humidity.svg" alt="Icono humedad">
                </div>
            </div>
            <div class="widget tem">
                <div class="titulo_dato">Movimiento</div>
                <div class="info">
                    <?php
                    // Conectar a la base de datos (repetido para cada dato)
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Seleccionar el último movimiento de la base de datos
                    $sql = "SELECT movimiento FROM mediciones ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo $row["movimiento"];
                        }
                    } else {
                        echo "No se encontraron datos";
                    }

                    $conn->close();
                    ?>
                    <img class="icono_tem" src="movement.svg" alt="Icono movimiento">
                </div>
            </div>
        </div>
    </div>

    <div class="mbl">
        <div class="widget full-width">
            <img src="habita.jpg" alt="">
            <div class="texto">
                <?php
                // Conectar a la base de datos (repetido para cada dato)
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Seleccionar la última hora de la base de datos
                $sql = "SELECT hora FROM mediciones ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo substr($row["hora"], 0, 5);
                    }
                } else {
                    echo "No se encontraron datos";
                }

                $conn->close();
                ?>
            </div>
            <div class="icono"><img class="icono_luz" src="sun_dark.svg" alt="Icono día"></div>
        </div>

        <div class="widget">
            <div class="widget-titulo">Temperatura</div>
            <div class="data">
                <?php
                // Conectar a la base de datos (repetido para cada dato)
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                // Seleccionar la última temperatura de la base de datos
                $sql = "SELECT temperatura FROM mediciones ORDER BY id DESC LIMIT 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo $row["temperatura"];
                    }
                } else {
                    echo "No se encontraron datos";
                }

                $conn->close();
                ?>
                °
                <img class="icono_tem" src="temperature.svg" alt="">
            </div>
        </div>

        <div class="widget">
            <div class="widget-titulo">Humedad</div>
            <div class="data widget-humidity" id="humidity-ring" data-humidity="74">
                <div>
                    <svg class="progress-ring" width="120" height="120">
                        <circle class="ring" cx="60" cy="60" r="54" fill="transparent" stroke="#ccc" stroke-width="6"></circle>
                        <circle class="progress" cx="60" cy="60" r="54" fill="transparent" stroke="#008DDA" stroke-width="6" stroke-dasharray="339.292" stroke-linecap="round"></circle>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#008DDA" font-size="24px">
                            <?php
                            // Conectar a la base de datos (repetido para cada dato)
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            if ($conn->connect_error) {
                                die("Error de conexión: " . $conn->connect_error);
                            }

                            // Seleccionar la última humedad de la base de datos
                            $sql = "SELECT humedad FROM mediciones ORDER BY id DESC LIMIT 1";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo $row["humedad"];
                                }
                            } else {
                                echo "No se encontraron datos";
                            }

                            $conn->close();
                            ?>
                            %
                        </text>
                    </svg>
                </div>
            </div>
        </div>

        <div class="widget full-width2">
            <div class="tit">Movimiento</div>
            <div class="contenedor_movimiento">
                <div class="alerta">
                    <?php
                    // Conectar a la base de datos (repetido para cada dato)
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Error de conexión: " . $conn->connect_error);
                    }

                    // Seleccionar el último movimiento de la base de datos
                    $sql = "SELECT movimiento FROM mediciones ORDER BY id DESC LIMIT 1";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row["movimiento"]) {
                                echo "Hay movimiento";
                                echo '<img class="icono_tem3" src="movement_no.svg" alt="">';
                            } else {
                                echo "No hay movimiento";
                                echo '<img class="icono_tem3" src="movement.svg" alt="">';
                            }
                        }
                    } else {
                        echo "No se encontraron datos";
                    }


                    $conn->close();
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="imagen_habita"></div>
    <script>
        setInterval(function() {
            location.reload();
        }, 5000); // 1000 milisegundos = 1 segundo
    </script>
    <script src="script.js"></script>
</body>

</html>