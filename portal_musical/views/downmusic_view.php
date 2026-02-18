<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Descargar Música</title>
</head>
<body>

<?php
if (isset($mensaje)) {
    echo "<p><strong>$mensaje</strong></p>";
}
?>

<form method="post">

    <label>Elige el producto:</label>
    <select name="Producto">
        <?php
        foreach ($canciones as $campo) {
            echo '<option value="' . $campo['TrackId'] . '">'. $campo['Name'] .'</option>';
        }
        ?>
    </select>
    <br><br>
    <input type="submit" name="anadir" value="Añadir a la cesta">
    <input type="submit" name="comprar" value="Comprar">

</form>

<h2>Cesta</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Canción</th>
        <th>Precio</th>
    </tr>

<?php
$total = 0;

foreach ($_SESSION['cesta'] as $i) {

    echo "<tr>";
    echo "<td>" . $i['nombre'] . "</td>";
    echo "<td>" . $i['precio'] . "</td>";
    echo "</tr>";

    $total += $i['precio'];
}
?>

    <tr>
        <td><strong>Total</strong></td>
        <td><strong><?php echo $total; ?> €</strong></td>
    </tr>

</table>

</body>
</html>