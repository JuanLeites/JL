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
        <div class="contenedordedatos">
            <div class="cantidaddeelementos"></div>
            <div class="recargartabla">recargar</div>
        </div>
        <table>
            <tbody pagina="1" actualizar="si" limite="20">
            </tbody>
        </table>
    </div>
    <?php include_once("barralateral.html") ?>
</body>

<script src="js/funcionessinexport.js"></script>
</html>