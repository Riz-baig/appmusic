<?php
session_start(); // Inicio sesión

require_once '../db/conexion.php';
require_once '../models/fun_invoice.php';
require_once '../Libreria/apiRedsys.php'; // Librería Redsys

$conn = conexion();

//Recojo datos enviados por Redsys 
$version = $_POST["Ds_SignatureVersion"] ?? null;
$datos   = $_POST["Ds_MerchantParameters"] ?? null;
$firma   = $_POST["Ds_Signature"] ?? null;

if (!$datos || !$firma) {
    http_response_code(400);
    exit("ERROR"); // Si faltan datos corto ejecución
}

//Decodifico parámetros
$miObj = new RedsysAPI();

$miObj->decodeMerchantParameters($datos); // Decodifico parámetros
$firmaCalculada = $miObj->createMerchantSignatureNotif("CLAVE_SECRETA_AQUI", $datos); // Genero firma propia

//Valido firma
if ($firmaCalculada !== $firma) {
    http_response_code(400);
    exit("Firma incorrecta"); // Si la firma no coincide, cancelo
}

//Obtengo datos importantes
$respuesta = $miObj->getParameter("Ds_Response"); // Código respuesta
$order     = $miObj->getParameter("Ds_Order");    // Nº pedido
$amount    = $miObj->getParameter("Ds_Amount");   // Importe en céntimos

//Compruebo si pago es correcto (0-99)
if ($respuesta >= 0 && $respuesta <= 99) {

    try {

        $conn->beginTransaction(); // Inicio transacción

        // Recupero datos de sesión
        if (!isset($_SESSION['customerId']) || !isset($_SESSION['cesta'])) {
            throw new Exception("Sesión no válida");
        }

        $customerId = $_SESSION['customerId']; // Cliente logueado
        $cesta = $_SESSION['cesta'];           // Productos comprados

        $total = calcularTotal($cesta); // Calculo total

        // Inserto factura
        $invoiceId = insertarInvoice($conn, $customerId, $total, $respuesta, $card, $order);

        // Inserto líneas de l a factura
        foreach ($cesta as $item) {
            if (!insertarInvoiceLine($conn, $invoiceId, $item['id'], $item['precio'])) {
                throw new Exception("Error insertando línea");
            }
        }

        $conn->commit(); // Confirmo cambios

        unset($_SESSION['cesta']); // Vacío cesta tras pago OK

        http_response_code(200);
        echo "OK"; // Respuesta obligatoria para Redsys

    } catch (Exception $e) {

        $conn->rollBack(); // hago rollback en caso de eroor
        http_response_code(500);
        echo "ERROR";
    }

} else {

    http_response_code(200);
    echo "PAGO DENEGADO"; // Pago rechazado
}
?>