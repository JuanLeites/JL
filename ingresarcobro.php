<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'INSERT INTO Cobro (Monto, ID_CLIENTE, Fecha_Cobro, Usuario) VALUES ("' . $_POST["monto"] . '","' . $_POST["ID_CLIENTE"] .'","'.date("Y-m-d").'","'.$_SESSION["usuario"].'");');
    $deudaanterior=mysqli_fetch_assoc(mysqli_query($basededatos,'SELECT Deuda from Cliente WHERE ID_CLIENTE="'.$_POST["ID_CLIENTE"].'";'));//obtenemos deuda anterior
    $deudaactual = $deudaanterior["Deuda"]-$_POST["monto"]; // le descontamos a la deuda el monto que le cobramos al cliente
    mysqli_query($basededatos,'UPDATE `Cliente` SET `Deuda`="'.$deudaactual.'" WHERE ID_CLIENTE="'.$_POST["ID_CLIENTE"].'";'); //actualizamos la deuda del cliente
    header("Location:ingresarcobro.php?opcion=cobroingresado");
    die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cobro</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/cobros.png" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Ingresar Cobro</h1>

        <label for="monto">Monto</label>
        <input min="1" max="1000000" type="number" id="monto" name="monto" placeholder="Monto" required>

        <label for="filtro">Buscar o <a class="enlace" target="_blank" href="agregarclientes.php">agregar clientes</a> </label> 
        <input id="filtro" type="search" placeholder="Buscar" class="filtroclientesparaselect">

        <select name="ID_CLIENTE" class="selectdeclientes" required></select>
        <input type="submit" value="Agregar">
    </form>
    <?php include_once("barralateral.html"); ?>
</body>
<script src="js/funcionessinexport.js">
</script>
</html>
<?php 
if(isset($_GET["opcion"]) && $_GET["opcion"] == "cobroingresado"){
    mostraraviso("Cobro ingresado con éxito, <br> Deuda actualizada",$colorfondo,$colorsecundario);
}
?>