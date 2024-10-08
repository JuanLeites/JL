<?php
include("chequeodelogin.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php");?>
    
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
        <table>
            <tbody>
            </tbody>
        </table>
    </div>

    <?php include("barralateral.html") ?>
</body>
<script type="module">
    import {cargarclientes} from "./js/funciones.js"
    var inputdeclientes = document.querySelector(".inputdeclientes")
    inputdeclientes.addEventListener("keyup", () => {cargarclientes(inputdeclientes.value)}) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

    window.onload = () => {
        cargarclientes();
        setInterval(() => {
            if (inputdeclientes.value == "") {
                cargarclientes();
            }

        }, 2000);
    }

</script>

</html>