<?php
//limpaia la entrada
function limpiar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//conexion con base de datos
function conexion() {
    try {
        $host = "localhost";
        $dbname = "musica";
        $user = "root";
        $password = "rootroot";

        $conn = new PDO( "mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;

    } catch (PDOException $e) {
        echo "Error al conectar con la base de datos: " . $e->getMessage();
        exit;
    }
}
?>