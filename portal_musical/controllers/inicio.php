<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    switch ($_POST['opcion']) {
        case 'downmusic':
            header("Location: downmusic.php");
            break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Portal Musical</title>
</head>
<body>

<h1>Bienvenido</h1>

<form method="post">
    <label>Selecciona una opción:</label><br><br>

    <select name="opcion" required>
        <option value="">-- Elige una opción --</option>
        <option value="downmusic">Descargar música</option>

    </select>

    <br><br>
    <input type="submit" value="Acceder">
</form>


</body>
</html>