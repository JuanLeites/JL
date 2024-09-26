<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="/LUPF/LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/LUPF/LIBRERIAS/sweetalert/sweetalert2.css">
    
    <?php include("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/icons/modproveedores.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="search" class="inputdeproveedores" placeholder="Buscar proveedores">
        <a href="/LUPF/agregar/agregarproveedores.php" class="agregardato">+</a>
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
    import {cargarproveedores} from "./js/funciones.js"
    
    var inputdeproveedores = document.querySelector(".inputdeproveedores");

    inputdeproveedores.addEventListener("keyup", () => {cargarproveedores(inputdeproveedores.value)}) //keyup porque toma el valor al levantar la tecla, se lo pasa a la funcion cargar proveedores la cual recive un parametro "filtro" con el cual hará la consulta a la api, en la api chequeamos que filtro esté seteada( distinto de undefined, porque al no estar seteada queda "undefined") y hacemos una consulta personalizada con la propiedad LIKE

    window.onload = () => {
        cargarproveedores()
        setInterval(() => {
            if (inputdeproveedores.value == "") {
                cargarproveedores()
            }
        }, 2000);
    }
</script>

</html>