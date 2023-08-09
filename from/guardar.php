<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellido_paterno = $_POST["Apellido_paterno"];
    $apellido_materno = $_POST["Apellido_materno"];
    $correo = $_POST["correo"];
    $telefono = $_POST["Telefono"];

    // Guardar en archivo JSON
    $nuevo_dato = array(
        "nombre" => $nombre,
        "apellido_paterno" => $apellido_paterno,
        "apellido_materno" => $apellido_materno,
        "correo" => $correo,
        "telefono" => $telefono
    );

    $datos_actuales = file_exists('datos.json') ? json_decode(file_get_contents('datos.json'), true) : array();
    $datos_actuales[] = $nuevo_dato;
    file_put_contents('datos.json', json_encode($datos_actuales));

    // Guardar en la base de datos
    $servername = "sql109.infinityfree.com";
    $username = "if0_34779913";
    $password = "ybpxnQFqqsfg";
    $dbname = "if0_34779913_Aunetbd";

    // Crear conexión
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar los datos en la tabla
    $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, telefono) 
            VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$correo', '$telefono')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();

    header("Location: form.html");
}
?>
