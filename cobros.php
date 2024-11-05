<?php include_once("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cobros</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/icons/cobros.png" type="image/x-icon">
    
    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
</head>

<body>
    <div class="tresinputs">
        <div class="subcontenedor">
            <a class="enlacesdebuscador" href="ingresarventa.php">Ingresar Venta</a>
            <a class="enlacesdebuscador" href="ingresarcobro.php">Ingresar Cobro</a>
        </div>


        <input type="search" placeholder="Buscar Cobro" class="inputdebusquedadecobro">
    </div>
    <div class="contenedordemenu tablabajolostresinputs">
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
<script src="js/funcionessinexport.js">
</script>

</html>