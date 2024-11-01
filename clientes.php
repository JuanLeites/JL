<?php
include_once("chequeodelogin.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">


    <link rel="shortcut icon" href="imagenes/icons/modclientes.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="search" class="inputdeclientes" placeholder="Buscar Clientes">
        <a href="agregarclientes.php" class="agregardato">+</a>
    </div>
    <div class="contenedordemenu">
        <div class="cantidaddeelementos"></div>
        <table>
            <tbody pagina="1">
            </tbody>
        </table>
    </div>

    <?php include_once("barralateral.html") ?>
</body>
<script src="js/funcionessinexport.js"></script>
<script type="module">
    import {
        cargarclientes
    } from "./js/funciones.js"

    var inputdeclientes = document.querySelector(".inputdeclientes")

    inputdeclientes.addEventListener("keyup", () => { //al escribir algo
        cargarclientes(inputdeclientes.value, 1) //cargará los clientes filtrados. pero solo pa página 1
        document.querySelector("tbody").setAttribute("pagina", 1) // seteamos la página en 1
    }) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

    window.onload = () => {
       
        cargarclientes("");
        setInterval(() => {
            var cantidaddepaginascargadasenlatabla = document.querySelector("tbody").getAttribute("pagina")
            var tabla = document.querySelector("tbody")
            if (inputdeclientes.value == "") { // si el contenido del buscador está vacío.
                cargarclientes("", cantidaddepaginascargadasenlatabla);
            } else {
                cargarclientes(inputdeclientes.value, 1)
            }

        }, 500);
    }
</script>

</html>