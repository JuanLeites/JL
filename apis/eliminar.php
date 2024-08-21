<?php
include("../coneccionBD.php");
include("../chequeodelogin.php");
if (isset($_GET["tipo"]) && isset($_GET["id"])) {

    switch ($_GET['tipo']) {
        case "cliente":
            mysqli_query($basededatos,'DELETE FROM cliente WHERE `cliente`.`ID_CLIENTE` = '.$_GET["id"]);
            json_encode("Cliente ".$_GET["id"]." Eliminado");
            break;;
        case "producto":
            $FOTODELPRODUCTO = mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT imagen FROM producto WHERE `producto`.`ID_Producto` = '.$_GET["id"]));//guardamos en la variable $FOTODELPRODUCTO un array asociativo que contiene el resultado de la consulta que solamente tendrá la ruta de la imagen con la id pasada por parametros
            @unlink("../IMAGENESSOFTWARE/".$FOTODELPRODUCTO["imagen"]);//le ponemos un arroba por si no encuentra la imagen no nos de un error
            mysqli_query($basededatos,'DELETE FROM producto WHERE `producto`.`ID_Producto` = '.$_GET["id"]);
            json_encode("Producto ".$_GET["id"]." Eliminado");
            break;;
        case "proveedor":
            mysqli_query($basededatos,'DELETE FROM proveedor WHERE `proveedor`.`ID_PROVEEDOR` ='.$_GET["id"]);
            json_encode("Proveedor ".$_GET["id"]." Eliminado");
            break;;
    }
}
