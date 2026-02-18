<?php
function validar($conn, $email, $clave)
{
    $sql = "SELECT * from customer where Email = :email and LastName = :clave";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>