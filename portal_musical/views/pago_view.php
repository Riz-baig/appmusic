<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ir a Redsys</title>
</head>
<body>

<h2>Pulsa para continuar al pago</h2>

<form action="<?php echo $urlRedsys; ?>" method="POST">
    <input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>" />
    <input type="hidden" name="Ds_MerchantParameters" value="<?php echo $paramsBase64; ?>" />
    <input type="hidden" name="Ds_Signature" value="<?php echo $firma; ?>" />
    
    <input type="submit" value="Ir a la pasarela de pago">
</form>

</body>
</html>