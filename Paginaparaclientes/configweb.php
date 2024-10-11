<?php

include_once("../chequeodelogin.php");
include_once("../coneccionBD.php");
include_once("../funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `Configuración` SET `Color_Principal` = "' . $_POST["colorprincipal"] . '",`Color_Secundario` = "' . $_POST["colorsecu"] . '", `Color_Fondo` = "' . $_POST["colorfon"] . '";');//actualizamos los precios por tickets
    $opcion = "configuracionactualizada";
} else {
    $opcion = "";
}

$consultaconfiguración = mysqli_query($basededatos, 'SELECT * FROM Configuración');
$config= mysqli_fetch_assoc($consultaconfiguración);
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

                    $configuraciondecolores = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Color_Principal,Color_Secundario,Color_Fondo FROM configuración;'));

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

    <form method="POST" class="formularios" style="max-width: 20%;text-align:center;">
    <h1>Configuración para página web destinada a clientes</h1>

        <label for="colorprincipal">Color Principal</label>
        <input type="color" name="colorprincipal" id="colorprincipal" value="<?php echo $config["Color_Principal"] ?>">

        <label for="colorsecu">Color Secundario</label>
        <input type="color" name="colorsecu" id="colorsecu" value="<?php echo $config["Color_Secundario"] ?>">

        <label for="colorfond">Color Fondo</label>
        <input type="color" name="colorfon" id="colorfon" value="<?php echo $config["Color_Fondo"] ?>">
        <input type="submit" value="Actualizar">
    </form>
    <a href="index.php" id="reg">PROBAR CONFIGURACIÓN</a>
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