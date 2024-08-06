<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
if(isset($_GET["id"])){
    $producto = mysqli_query($basededatos,'SELECT * FROM producto WHERE ID_PRODUCTO='.$_GET["id"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
</head>
<body>
    
</body>
</html>