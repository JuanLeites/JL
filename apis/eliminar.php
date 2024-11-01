<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");
if (isset($_GET["tipo"]) && isset($_GET["id"])) {

    switch ($_GET['tipo']) {
        case "cliente":
            mysqli_query($basededatos, 'UPDATE `Cliente` SET `Activo` = FALSE WHERE `ID_CLIENTE` = ' . $_GET["id"]);
            json_encode("Cliente " . $_GET["id"] . " Actualizado a Desactivo");
            header('Content-Type: application/json', true, 200);
            break;;
        case "producto":
            $FOTODELPRODUCTO = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT imagen FROM Producto WHERE `producto`.`ID_PRODUCTO` = ' . $_GET["id"])); //guardamos en la variable $FOTODELPRODUCTO un array asociativo que contiene el resultado de la consulta que solamente tendrá la ruta de la imagen con la id pasada por parametros
            @unlink("../IMAGENESSOFTWARE/" . $FOTODELPRODUCTO["imagen"]); //le ponemos un arroba por si no encuentra la imagen no nos de un error
            mysqli_query($basededatos, 'UPDATE `Producto` SET `Activo` = FALSE WHERE `producto`.`ID_PRODUCTO` = ' . $_GET["id"]);
            json_encode("Producto " . $_GET["id"] . " Actualizado a Desactivo");
            header('Content-Type: application/json', true, 200);
            break;;
        case "proveedor":
            mysqli_query($basededatos, 'UPDATE `Proveedor` SET `Activo` = FALSE WHERE `proveedor`.`ID_PROVEEDOR` =' . $_GET["id"]);
            json_encode("Proveedor " . $_GET["id"] . " Actualizado a Desactivo");
            header('Content-Type: application/json', true, 200);
            break;;
        case "sorteo":
            mysqli_query($basededatos, 'DELETE FROM Sorteo WHERE `ID_SORTEO` = "'.$_GET["id"].'";');
            json_encode("Sorteo  " . $_GET["id"] . " Eliminado");
            header('Content-Type: application/json', true, 200);
            break;;
        case "sorteorealizado":
            mysqli_query($basededatos, 'UPDATE `Sorteo` SET `Activo` = FALSE WHERE `sorteo`.`ID_SORTEO` =' . $_GET["id"]);
            json_encode("Sorteo  " . $_GET["id"] . " Actualizado a Desactivo");
            header('Content-Type: application/json', true, 200);
    }
}else{
    json_encode(["error"=>["Datos incompletos"]]);
    header('Content-Type: application/json', true, 400);
}
