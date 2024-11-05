<?php
include_once("../coneccionBD.php");
include_once("../chequeodelogin.php");

if (isset($_GET["tipo"])){
    switch ($_GET['tipo']) {
        case "cliente":
            $cantidad = mysqli_query($basededatos, 'SELECT Count(*)"cantidad" FROM Cliente WHERE Activo=TRUE');
            break;
        case "producto":
            $cantidad = mysqli_query($basededatos, 'SELECT Count(*)"cantidad" FROM Producto WHERE Activo=TRUE');
            break;
        case "proveedor":
            $cantidad = mysqli_query($basededatos,'SELECT Count(*)"cantidad" FROM Proveedor WHERE Activo=TRUE');
            break;
        case "sorteo":
            $cantidad = mysqli_query($basededatos,'SELECT Count(*)"cantidad" FROM Sorteo WHERE Activo=TRUE');
            break;
        case "pago":
            $cantidad = mysqli_query($basededatos,'SELECT Count(*)"cantidad" FROM Pago');
            break;
        case "cobro":
            $cantidad = mysqli_query($basededatos,'SELECT Count(*)"cantidad" FROM Cobro');
            break;
        case "productoconstock":
            $cantidad = mysqli_query($basededatos, 'SELECT Count(*)"cantidad" FROM Producto WHERE Activo=TRUE and Cantidad>0');
            break;
        default:
            $cantidad = "tipo incorrecto";
            header('Content-Type: application/json', true, 400);
            echo json_encode(["error" => "Tipo de dato incorrecto"]);
            die();//para que no siga
            break;
        }
        $cantidad = mysqli_fetch_assoc($cantidad);
        $cantidad = $cantidad["cantidad"];
        echo json_encode($cantidad);
        header('Content-Type: application/json', true, 200);
        json_encode($cantidad);
} else {
    header('Content-Type: application/json', true, 400);
    echo json_encode(["error" => "Tipo de dato no seleccionado"]);
}

