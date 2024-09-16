<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/icons/modproveedores.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar proveedores">
        <a href="agregarproveedores.php" class="agregardato">+</a>
    </div>

    <div class="contenedordemenu">
        <table>
            <tbody>

            </tbody>
        </table>
    </div>
    
    <?php include("barralateral.html") ?>
</body>

<script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <script type="module">
    import {cargarproveedores} from "./js/funciones.js"
    window.onload = () => {
     cargarproveedores()
     setInterval(() => {
         cargarproveedores()
     }, 2000);
 }

</script>

</html>