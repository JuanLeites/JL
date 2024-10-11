<?php

include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Color_Principal` = "' . $_POST["colorprincipal"] . '", `Color_Secundario` = "' . $_POST["colorsecu"] . '", `Color_Fondo` = "' . $_POST["colorfon"] . '"  WHERE Usuario ="' . $_SESSION["usuario"] . '";');
    mysqli_query($basededatos, 'UPDATE `Configuración` SET `Precio_por_Tickets` = "' . $_POST["precioxtiket"] . '"');//actualizamos los precios por tickets
    $opcion = "configuracionactualizada";
} else {
    $opcion = "";
}

$consultausuario = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
$consultaconfiguración = mysqli_query($basededatos, 'SELECT * FROM Configuración');
$config= mysqli_fetch_assoc($consultaconfiguración);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar configuración</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
    ?>
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

</head>

<body>
    <form method="POST" class="formularios">

        <label for="precioxtiket">Precio para Generación de Tickets</label>
        <input type="number" step="0.10" min="1" max="10000" name="precioxtiket" id="precioxtiket" value="<?php echo $config["Precio_por_Tickets"] ?>">

        <label for="colorprincipal">Color Principal</label>
        <input type="color" name="colorprincipal" id="colorprincipal" value="<?php echo $usuario["Color_Principal"] ?>">

        <label for="colorsecu">Color Secundario</label>
        <input type="color" name="colorsecu" id="colorsecu" value="<?php echo $usuario["Color_Secundario"] ?>">

        <label for="colorfond">Color Fondo</label>
        <input type="color" name="colorfon" id="colorfon" value="<?php echo $usuario["Color_Fondo"] ?>">
        <input type="submit" value="Actualizar">
    </form>
    <a href="menuprincipal.php" id="reg">regresar</a>
</body>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'configuracionactualizada';
        mostraraviso('Configuración modificada con éxito', $colorfondo, $colorprincipal);
        break;
}
?>