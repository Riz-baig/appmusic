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
    <title>Pago correcto</title>
</head>
<body>

<h1>Pago realizado correctamente</h1>

<p>Tu compra ha sido procesada con éxito.</p>

<a href="inicio.php">Volver al inicio</a>

</body>
</html>