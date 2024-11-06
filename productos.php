<?php include_once("chequeodelogin.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="css/style.css">
    <?php
    include_once("coneccionBD.php");
    include_once("css/colorespersonalizados.php"); //se incluye archivo que imprime las variables de estilos establecidas en la base de datos si es que la variable de session usuario está seteada
    ?>
    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
    <link rel="shortcut icon" href="imagenes/icons/productos.png" type="image/x-icon">
</head>

<body>
    <div class="buscador">
        <input type="search" class="inputdeproductos" placeholder="Buscar Productos">
        <a href="agregarproductos.php" class="agregardato">+</a>
    </div>
    <div class="contenedordemenu">
        <div class="contenedordedatos" id="top">
            <div class="cantidaddeelementos"></div>
            <div class="recargartabla">recargar</div>
        </div>
        <table>
            <tbody pagina="1" actualizar="si" limite="20">
            </tbody>
        </table>
    </div>
    <a href="#top" class="button" style="transform:scale(0);">
        <svg class="svgIcon" viewBox="0 0 384 512">
            <path
                d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"></path>
        </svg>
    </a>
    <?php include_once("barralateral.html") ?>
</body>

<script src="js/funcionessinexport.js"></script>
</html>