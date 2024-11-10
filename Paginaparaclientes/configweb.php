<?php
include_once("../chequeodelogin.php");
include_once("../coneccionBD.php");
include_once("../funciones.php");

if(!isset($_SESSION["administador"])){
    header("Location:../menuprincipal.php");
    die();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `Configuración` SET `Color_Principal` = "' . $_POST["colorprincipal"] . '", `Clave_Maestra` = "' . $_POST["clavemaestra"] . '",`Color_Secundario` = "' . $_POST["colorsecu"] . '", `Color_Fondo` = "' . $_POST["colorfon"] . '";'); //actualizamos los precios por tickets
    $opcion = "configuracionactualizada";
} else {
    $opcion = "";
}

$consultaconfiguración = mysqli_query($basededatos, 'SELECT * FROM Configuración');
$config = mysqli_fetch_assoc($consultaconfiguración);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar configuración</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        <?php

        $configuraciondecolores = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Color_Principal,Color_Secundario,Color_Fondo FROM Configuración;'));

        $colorprincipal = $configuraciondecolores["Color_Principal"];
        $colorsecundario = $configuraciondecolores["Color_Secundario"];
        $colorfondo = $configuraciondecolores["Color_Fondo"];
        //las variables $colorfondo, $colorprincipal salen de este archivo
        ?> :root {
            --color-principal: <?php echo $colorprincipal ?>;
            --color-secundario: <?php echo $colorsecundario ?>;
            --color-fondo: <?php echo $colorfondo ?>;
        }
    </style>
    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">

    <script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">

</head>

<body>

    <form method="POST" class="formularios" style="text-align:center;">
        <label for="clavemaestra">Clave Maestra</label>
        <input type="text" name="clavemaestra" id="clavemaestra" value="<?php echo $config["Clave_Maestra"] ?>">
        <br>

        <label for="contenedordeinputs">Colores de página pública: </label>
        <br>
        <div class="contenedordeinputs" id="contenedordeinputs">

            <label for="colorprincipal">Color Principal</label>
            <input type="color" name="colorprincipal" id="colorprincipal" value="<?php echo $config["Color_Principal"] ?>">

            <label for="colorsecu">Color Secundario</label>
            <input type="color" name="colorsecu" id="colorsecu" value="<?php echo $config["Color_Secundario"] ?>">

            <label for="colorfond">Color Fondo</label>
            <input type="color" name="colorfon" id="colorfon" value="<?php echo $config["Color_Fondo"] ?>">
        </div>
        <input type="submit" value="Actualizar">
        <a href="index.php" class="botonconfiguración" >probar configuración de la página</a>
    </form>

    <a href="../modificarconfiguracion.php" id="reg">Regresar</a>
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