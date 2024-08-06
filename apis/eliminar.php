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
            mysqli_query($basededatos,'DELETE FROM producto WHERE `producto`.`ID_Producto` = '.$_GET["id"]);
            json_encode("Producto ".$_GET["id"]." Eliminado");
            break;;
        case "proveedor":
            mysqli_query($basededatos,'DELETE FROM proveedor WHERE `proveedor`.`ID_PROVEEDOR` ='.$_GET["id"]);
            json_encode("Proveedor ".$_GET["id"]." Eliminado");
            break;;
    }
}
