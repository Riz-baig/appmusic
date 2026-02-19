<?php
session_start();

if (!isset($_SESSION['customerId'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago rechazado</title>
</head>
<body>

<h1>Pago rechazado</h1>

<p>La operación no se ha podido completar.</p>
<p>Por favor, inténtalo de nuevo.</p>

<a href="downmusic.php">Volver a la tienda</a>

</body>
</html>