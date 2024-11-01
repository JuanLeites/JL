<?php include_once("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/icons/pagos.png" type="image/x-icon">
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
        <div class="cantidaddeelementos"></div>
        <table>
            <tbody pagina="1" actualizar="si">
            </tbody>
        </table>
    </div>
    <?php include_once("barralateral.html") ?>
</body>
<script type="module">
    import {
        cargarpagos
    } from "./js/funciones.js"
    var inputdepagos = document.querySelector(".inputdebusquedadepago");
    inputdepagos.addEventListener("keyup", () => {
        cargarpagos(inputdepagos.value,1)
        document.querySelector("tbody").setAttribute("pagina", 1)
    })
    window.onload = () => {
        cargarpagos("","");
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")

            if (inputdepagos.value == "") {
                cargarpagos("",cantidaddepaginascargadasenlatabla);
            } else {
                cargarpagos(inputdepagos.value,cantidaddepaginascargadasenlatabla);
            }
        }, 2000);
    }
</script>

</html>