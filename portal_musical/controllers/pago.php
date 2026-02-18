<?php
session_start();

require_once '../Libreria/Libreria-de-firma-para-PHPv2/redsysHMAC512/signatureUtils/signature.php';
require_once '../Libreria/Libreria-de-firma-para-PHPv2/redsysHMAC512/signatureUtils/utils.php';

// Compruebo que hay cesta
if (!isset($_SESSION['cesta']) || empty($_SESSION['cesta'])) {
    header("Location: downmusic.php");
    exit();
}

$cesta = $_SESSION['cesta'];

//Calculo total 
$total = 0;
foreach ($cesta as $item) {
    $total += $item['precio'];
}

$importe = intval(round($total * 100)); // paso el importe a centimos

//Genero número de pedido 
$order = date("YmdHis"); // Más seguro que solo His
$_SESSION['order'] = $order;

//Datos comercio
$merchantCode = "999008881"; // Pruebas
$terminal     = "1";
$currency     = "978"; // EUR
$transaction  = "0";   // Autorización

$merchantURL = "http://localhost/Php/portal_musical/controllers/notificacion.php";
$urlOK       = "http://localhost/Php/portal_musical/controllers/ok.php";
$urlKO       = "http://localhost/Php/portal_musical/controllers/ko.php";


$params = [
    "DS_MERCHANT_AMOUNT" => $importe,
    "DS_MERCHANT_ORDER" => $order,
    "DS_MERCHANT_MERCHANTCODE" => $merchantCode,
    "DS_MERCHANT_CURRENCY" => $currency,
    "DS_MERCHANT_TRANSACTIONTYPE" => $transaction,
    "DS_MERCHANT_TERMINAL" => $terminal,
    "DS_MERCHANT_MERCHANTURL" => $merchantURL,
    "DS_MERCHANT_URLOK" => $urlOK,
    "DS_MERCHANT_URLKO" => $urlKO
];

$paramsBase64 = base64_encode(json_encode($params));

$clave = "sq7HjrUOBfKmC576ILgskD5srU870gJ7";

$firma = Signature::createMerchantSignature($clave, $paramsBase64, $order);

$version = "HMAC_SHA512_V2";

$urlRedsys = "https://sis-t.redsys.es:25443/sis/realizarPago";

require_once '../views/pago_view.php';
?>