<?php
require_once '../db/conexion.php';
require_once '../models/funciones_Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $conn = conexion();
    $email = limpiar($_POST['usuario']);
    $clave = limpiar($_POST['contrasena']);

    $cliente = validar($conn, $email, $clave);

    if ($cliente) {
        setcookie('customerId', $cliente['CustomerId'], time() + 3600, '/');
        header("Location: inicio.php");
        exit();
} else {
    header("Location: ../index.php");
    }
    exit;
}

?>