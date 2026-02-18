<?php
session_start();

require_once '../db/conexion.php';
require_once '../models/fun_downmusic.php';

$conn = conexion();
$canciones = obtenerCanciones($conn);

if (!isset($_SESSION['cesta'])) {// Inicializo la cesta vacia
    $_SESSION['cesta'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['anadir']) && isset($_POST['Producto'])) {// cuando recibe el boton añadir
        $trackId = $_POST['Producto'];
        
        foreach ($canciones as $cancion) {// Buscar canción dentro de $canciones y anotaar el precio en la cesta
            if ($cancion['TrackId'] == $trackId) {
                $_SESSION['cesta'][] = ['id'=> $cancion['TrackId'], 'nombre' => $cancion['Name'],'precio' => $cancion['UnitPrice']];
                break; 
            }
        }
    }

    // Comprar (vaciar cesta)
    if (isset($_POST['comprar'])) {
        $mensaje = "Compra realizada correctamente.";
        $_SESSION['cesta'] = [];
    }
}

// Cargar vista
require_once '../views/downmusic_view.php';