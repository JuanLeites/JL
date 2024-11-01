<?php
include_once("chequeodelogin.php");
include_once("funciones.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteos</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/sorteo.png" type="image/x-icon">

</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Sorteos" class="inputparabuscarsorteos">
        <a href="agregarsorteos.php" class="agregardato">+</a>
    </div>
    <div class="contenedordemenu">
        <div class="cantidaddeelementos"></div>
        <table>
            <tbody>
            </tbody>
        </table>

    </div>
    <?php include_once("barralateral.html") ?>
</body>

<script src="js/funcionessinexport.js"></script>
<script type="module">
    import {
        cargarsorteos
    } from "./js/funciones.js"

    var inputdesorteos = document.querySelector(".inputparabuscarsorteos");

    inputdesorteos.addEventListener("keyup", () => {
        cargarsorteos(inputdesorteos.value)
    }) // le agregamos la función cargarcobros y le pasamos por parametro el "filtro". esto lo hace al levantar la tecla

    window.onload = () => {
        cargarsorteos()
        setInterval(() => {
            if (inputdesorteos.value == "") { //si el input está vacío recarga, esto es para que no interrumpa la funcion cuando está filtrando
                cargarsorteos()
            } else {
                cargarsorteos(inputdesorteos.value)
            }
        }, 2000);
    }
</script>

</html>

<?php
if (isset($_GET["causa"])) {
    switch ($_GET['causa']) {
        case "idnoseteada":
            mostraralerta("ID de sorteo no seteada", $colorfondo, $colorprincipal);
            break;;
        case "maspremiosqueclientes":
            mostraralerta("No hay suficientes clientes con Tickets para poder realizar ese sorteo", $colorfondo, $colorprincipal);
            break;;
        case "clientessintickets":
            mostraralerta("Ningun cliente tiene tickets", $colorfondo, $colorprincipal);
            break;;
        case "sorteoyarealizado":
            mostraralerta("El sorteo ya fue realizado", $colorfondo, $colorprincipal);
            break;;
    }
}

?>