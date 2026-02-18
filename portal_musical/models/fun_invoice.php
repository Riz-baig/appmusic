<?php

function insertarInvoice($conn, $customerId, $total, $respuesta, $card, $order) {

    // Obtener último InvoiceId
    $sqlMax = "SELECT MAX(InvoiceId) AS maxId FROM Invoice";
    $stmtMax = $conn->prepare($sqlMax);
    $stmtMax->execute();
    $id = $stmtMax->fetch(PDO::FETCH_ASSOC);

    $nuevoId = ($id['maxId'] ?? 0) + 1;

    // Extraigo últimos 4 dígitos tarjeta
    $ultimos4 = substr($card, -4);

    $sql = "INSERT INTO Invoice 
            (InvoiceId, CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingCountry, BillingPostalCode, Total)
            VALUES (:id, :cust, NOW(), :direccion, :ciudad, :pais, :postal, :total)";

    $stmt = $conn->prepare($sql);

    $direccion = "Pago Redsys";
    $ciudad    = $ultimos4;      // Guardo últimos 4 dígitos
    $pais      = $respuesta;     // Código respuesta
    $postal    = $order;         // Nº pedido

    $stmt->bindParam(':id', $nuevoId);
    $stmt->bindParam(':cust', $customerId);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':pais', $pais);
    $stmt->bindParam(':postal', $postal);
    $stmt->bindParam(':total', $total);

    $stmt->execute();

    return $nuevoId;
}



function insertarInvoiceLine($conn, $invoiceId, $trackId, $precio) {

    //Obtengo último InvoiceLineId
    $sqlMax = "SELECT MAX(InvoiceLineId) AS maxId FROM InvoiceLine";
    $stmtMax = $conn->prepare($sqlMax);
    $stmtMax->execute();
    $num = $stmtMax->fetch(PDO::FETCH_ASSOC);

    $nuevoId = $num['maxId']+ 1;


    //Inserto línea con
    $sql = "INSERT INTO InvoiceLine 
            (InvoiceLineId, InvoiceId, TrackId, UnitPrice, Quantity)
            VALUES (:id, :invoice, :track, :price, 1)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $nuevoId);
    $stmt->bindParam(':invoice', $invoiceId);
    $stmt->bindParam(':track', $trackId);
    $stmt->bindParam(':price', $precio);

    return $stmt->execute();
}



function calcularTotal($cesta) {

    $total = 0;

    foreach ($cesta as $item) {
        $total += $item['precio'];
    }

    return $total;
}

?>