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
        <table>
            <tbody>
            </tbody>
        </table>
    </div>
    <?php include_once("barralateral.html") ?>
</body>
<script type="module">
    import {cargarcobros} from "./js/funciones.js"
    var inputdecobros = document.querySelector(".inputdebusquedadecobro");
    inputdecobros.addEventListener("keyup",()=>{cargarcobros(inputdecobros.value)})
    window.onload = () => {
        cargarcobros();
        setInterval(() => {
            if(inputdecobros.value==""){
                cargarcobros();
            }else{
                cargarcobros(inputdecobros.value);
            }
        }, 2000);
    }
</script>

</html>