<?php
function obtenerCanciones($conn){
    $sql = "SELECT * FROM track";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>