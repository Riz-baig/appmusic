<?php

function insertarInvoice($conn, $customerId, $total) {

    $sql = "INSERT INTO Invoice 
            (CustomerId, InvoiceDate, BillingAddress, BillingCity, BillingCountry, BillingPostalCode, Total)
            VALUES (:cust, NOW(), 'Online', 'Online', 'Spain', '00000', :total)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':cust'  => $customerId,
        ':total' => $total
    ]);

    return $conn->lastInsertId();
}


function insertarInvoiceLine($conn, $invoiceId, $trackId, $precio) {

    $sql = "INSERT INTO InvoiceLine 
            (InvoiceId, TrackId, UnitPrice, Quantity)
            VALUES (:invoice, :track, :price, 1)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        ':invoice' => $invoiceId,
        ':track'   => $trackId,
        ':price'   => $precio
    ]);
}

function calcularTotal($cesta) {

    $total = 0;

    foreach ($cesta as $item) {
        $total += $item['precio'];
    }

    return $total;
}


?>