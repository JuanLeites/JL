<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="./imagenes/icons/carrito.png" type="image/x-icon">
</head>

<body>
    <div class="tresinputs">
        <div class="subcontenedor">
            <a class="enlacesdebuscador" href="ingresarcompra.php">Ingresar Compra</a>
            <a class="enlacesdebuscador" href="ingresarpago.php">Ingresar Pago</a>
        </div>


        <input type="search" placeholder="Buscar Pago" class="inputdebusquedadepago">
    </div>
    <div class="contenedordemenu tablabajolostresinputs">
        <table>
            <tbody>
            </tbody>
        </table>
    </div>
    <?php include("barralateral.html") ?>
</body>
<script type="module">
    import {cargarpagos} from "./js/funciones.js"
    var inputdepagos = document.querySelector(".inputdebusquedadepago");
    inputdepagos.addEventListener("keyup",()=>{cargarpagos(inputdepagos.value)})
    window.onload = () => {
        cargarpagos();
        setInterval(() => {
            if(inputdepagos.value==""){
                cargarpagos();
            }
        }, 2000);
    }
</script>

</html>