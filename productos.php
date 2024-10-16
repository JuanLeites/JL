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
    include_once("css/colorespersonalizados.php");//se incluye archivo que imprime las variables de estilos establecidas en la base de datos si es que la variable de session usuario está seteada
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
        <table>
            <tbody>
            </tbody>
        </table>
    </div>


    <?php include_once("barralateral.html") ?>

</body>

<script type="module">
    import {
        cargarproductos
    } from "././js/funciones.js"

    var inputdeproductos = document.querySelector(".inputdeproductos");
    inputdeproductos.addEventListener("keyup", () => {
        cargarproductos(inputdeproductos.value)
    }) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

    window.onload = () => {
        cargarproductos();
        setInterval(() => {
            if (inputdeproductos.value == "") {
                cargarproductos();
            }
        }, 2000);
    }
</script>

</html>