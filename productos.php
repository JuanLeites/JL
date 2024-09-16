<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/icons/modproductos.png" type="image/x-icon">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Productos">
        <a href="agregarproductos.php" class="agregardato">+</a>
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
    import {cargarproductos} from "./js/funciones.js"
    window.onload = () => {
        cargarproductos()
        setInterval(() => {
            cargarproductos()
        }, 2000);
    }
</script>

</html>