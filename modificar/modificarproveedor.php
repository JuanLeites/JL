<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
if(isset($_GET["id"])){
    $proveedor = mysqli_query($basededatos,'SELECT * FROM proveedor WHERE ID_PROVEEDOR='.$_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
</head>
<body>
    
</body>
</html>