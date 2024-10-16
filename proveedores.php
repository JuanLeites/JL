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
        <table>
            <tbody>

            </tbody>
        </table>
    </div>

    <?php include_once("barralateral.html") ?>
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