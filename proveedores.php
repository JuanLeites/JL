<?php include_once("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <?php include_once("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/icons/proveedor.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="search" class="inputdeproveedores" placeholder="Buscar proveedores">
        <a href="agregarproveedores.php" class="agregardato">+</a>
    </div>

    <div class="contenedordemenu">
        <div class="contenedordedatos">
            <div class="cantidaddeelementos"></div>
            <div class="recargartabla">recargar</div>
        </div>
        <table>
            <tbody pagina="1" actualizar="si" limite="30">

            </tbody>
        </table>
    </div>

    <?php include_once("barralateral.html") ?>
</body>

<script src="js/funcionessinexport.js"></script>
</html>