<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
include("../funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `proveedor` SET `Contacto` = "' . $_POST["contacto"] . '", `Razón_Social` = "' . $_POST["RS"] . '", `RUT` = "' . $_POST["rut"] . '" WHERE `proveedor`.`ID_PROVEEDOR` =' . $_GET["id"]);
    $opcion = "proveedoractualizado";
} else {
    $opcion = "";
}

if (isset($_GET["id"])) {
    $consultaproveedor = mysqli_query($basededatos, 'SELECT * FROM proveedor WHERE ID_PROVEEDOR=' . $_GET["id"]);
    $proveedor = mysqli_fetch_assoc($consultaproveedor);
} else {
    header("Location:/LUPF/proveedores.php");
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include("../css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
    ?>
    <link rel="shortcut icon" href="../imagenes/icons/modproveedores.png" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Modificar Proveedor</h1>
        <label for="RS">Razón Social</label>
        <input type="text" placeholder="Razón Social" name="RS" id="RS" value="<?php echo $proveedor['Razón_Social']; ?>">

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" min="1000000" max="999999999999" name="rut" id="rut" value="<?php echo $proveedor['RUT']; ?>">

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" value="<?php echo $proveedor['Contacto']; ?>">

        <input type="submit" value="Actualizar">

    </form>
    <a href="/LUPF/proveedores.php" id="reg">regresar</a>
</body>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'proveedoractualizado';
        mostraraviso('Proveedor modificado con éxito', $colorfondo, $colorprincipal);
        break;
}
?>