<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");
    
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'INSERT INTO Pago (Monto, ID_PROVEEDOR, Fecha_Pago, Usuario) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_PROVEEDOR"] .'","'.date("Y-m-d").'","'.$_SESSION["usuario"].'");');
    
    $deudaanterior=mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Deuda from Proveedor WHERE ID_PROVEEDOR="'.$_POST["ID_PROVEEDOR"].'";'));//obtenemos deuda anterior
    $deudaactual = $deudaanterior["Deuda"]-$_POST["monto"]; // le descontamos a la deuda el monto que le cobramos al cliente
    mysqli_query($basededatos,'UPDATE `proveedor` SET `Deuda`="'.$deudaactual.'" WHERE ID_PROVEEDOR="'.$_POST["ID_PROVEEDOR"].'";'); //actualizamos la deuda del cliente
    header("Location:ingresarpago.php?opcion=pagoingresado");
    die();
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pago</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/pagos.png" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Agregar Pago</h1>

        <label for="monto">Monto</label>
        <input min="1" max="1000000" type="number" id="monto" name="monto" placeholder="Monto" required>

        <label for="filtro">Buscar o <a class="enlace" target="_blank" href="agregarproveedores.php">agregar proveedores</a> </label> 
        <input id="filtro" type="search" placeholder="Buscar" class="filtroproveedoreparaselect">

        <select name="ID_PROVEEDOR" class="selectdeproveedores" required></select>
        <input type="submit" value="Agregar">
    </form>
    <?php include_once("barralateral.html"); ?>
</body>


<script src="js/funcionessinexport.js"></script>
</html>

<?php


if(isset($_GET["opcion"]) && $_GET["opcion"] == "pagoingresado"){
    mostraraviso("Pago ingresado con éxito<br> Deuda actualizada",$colorfondo,$colorsecundario);
}
    
    ?>