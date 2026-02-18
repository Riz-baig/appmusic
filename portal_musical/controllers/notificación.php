<?php
session_start();

require_once '../db/conexion.php';
require_once '../models/fun_invoice.php';

$conn = conexion();

if ($respuesta >= 0 && $respuesta <= 99) {

    try {

        $conn->beginTransaction();

        $customerId = $_COOKIE['customerId'];
        $cesta = $_SESSION['cesta'];

        $total = calcularTotal($cesta);

        $invoiceId = insertarInvoice($conn, $customerId, $total);

        foreach ($cesta as $item) {

            if (!insertarInvoiceLine($conn, $invoiceId, $item['id'], $item['precio'])) {
                throw new Exception("Error insertando línea");
            }
        }

        $conn->commit();
        unset($_SESSION['cesta']);

        http_response_code(200);
        echo "OK";

    } catch (Exception $e) {

        $conn->rollBack();
        http_response_code(500);
        echo "ERROR";
    }
}

?>
