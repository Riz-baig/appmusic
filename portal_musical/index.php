<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de login</title>   
</head>
<body>
<form method="post" action="controllers/login.php">
    <h1>Acceso a la plataforma</h1>
    <br><br>

    <label>Usuario: </label>
    <input type="text" name="usuario"><br><br>

    <label>Contraseña: </label>
    <input type="password" name="contrasena"><br><br>


    <input type="submit" value="Acceder">
    </form>
<?php

    if (isset($_GET['error'])) {
        echo "<p style='color:red'>Usuario o contraseña incorrectos</p>";
    }
?>

</body>
</html>