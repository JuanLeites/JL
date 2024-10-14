<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["RS"]) && isset($_POST["rut"]) && isset($_POST["contacto"])) {
        if ($_POST["RS"] != ""  && $_POST["contacto"] != "") {
            mysqli_query($basededatos, 'INSERT INTO proveedor (Contacto, Razón_Social,RUT) VALUES ("' . $_POST["contacto"] . '","' . $_POST["RS"] . '","' . $_POST["rut"] . '");');
            $opcion = "proveedorregistrado";
        } else {
            $opcion="datosincompletos";
        }
    } else {
        $opcion="datosnoseteados";
    }
}else{
    $opcion="";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proveedore</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  ?>
    
    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
    
    <link rel="shortcut icon" href="imagenes/icons/proveedor.png" type="image/x-icon">

</head>

<body>

    <form method="POST" class="formularios">
        <h1>Agregar Proveedor</h1>
        <label for="RS">Razón Social</label>
        <input type="text" placeholder="Razón Social" name="RS" id="RS" required>

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" min="1000000" max="999999999999" name="rut" id="rut" >

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" required>

        <input type="submit" value="agregar">

    </form>

    <?php include_once("barralateral.html") ?>
</body>
</html>
<?php
switch ($opcion) {
    case 'proveedorregistrado';
        mostraraviso("Proveedor registrado con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosincompletos';
        mostraralerta("Debe rellenar todos los campos", $colorfondo, $colorprincipal);
        break;
    case 'datosnoseteados';
        mostraralerta("Datos no seteados", $colorfondo, $colorprincipal);
        break;
}

?>