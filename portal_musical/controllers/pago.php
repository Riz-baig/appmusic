<?php
session_start();

require_once '../db/conexion.php';

// Librería Redsys
require_once '../Libreria/Libreria-de-firma-para-PHPv2/redsysHMAC512/signatureUtils/signature.php';
require_once '../Libreria/Libreria-de-firma-para-PHPv2/redsysHMAC512/signatureUtils/utils.php';

// Comprobar que hay cesta
if (!isset($_SESSION['cesta']) || empty($_SESSION['cesta'])) {
    header("Location: downmusic.php");
    exit();
}

$cesta = $_SESSION['cesta'];

// 1️⃣ Calcular total real
$total = 0;
foreach ($cesta as $item) {
    $total += $item['precio'];
}

// Redsys trabaja en céntimos
$importe = intval(round($total * 100));

// 2️⃣ Generar número de pedido (solo números, máx 12 caracteres)
$order = date("His") . rand(10,99); 

// 3️⃣ Datos comercio PRUEBAS
$merchantCode = "999008881"; // tu código de comercio
$terminal     = "1";
$currency     = "978"; // EUR
$transaction  = "0";   // Autorización

// 4️⃣ URLs
$merchantURL = "http://localhost/tu_ruta/controllers/notificacion.php";
$urlOK       = "http://localhost/tu_ruta/controllers/ok.php";
$urlKO       = "http://localhost/tu_ruta/controllers/ko.php";

// 5️⃣ Crear parámetros Redsys
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

// Convertir a JSON + base64
$paramsBase64 = base64_encode(json_encode($params));

// 6️⃣ Firmar
$clave = "sq7HjrUOBfKmC576ILgskD5srU870gJ7"; // clave pruebas

$firma = Signature::createMerchantSignature($clave, $paramsBase64);

$version = "HMAC_SHA512_V2";

// 7️⃣ URL Redsys PRUEBAS
$urlRedsys = "https://sis-t.redsys.es:25443/sis/realizarPago";

// Cargar vista
require_once '../views/pago_view.php';