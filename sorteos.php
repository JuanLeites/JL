<?php
include("chequeodelogin.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Sorteos">
    </div>
    <div class="contenedordemenu">
        <table>
            <tbody>
            </tbody>
        </table>
        <a href="agregarsorteos.php" class="agregardato">+</a>
    </div>
    <?php include("barralateral.html") ?>
</body>

<script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
<script type="module">
    import {asignarbotoneliminar} from "./js/funciones.js"

    window.onload = () => {
        cargarsorteos()
        setInterval(() => {
            cargarsorteos()
        }, 2000);
    }


    function cargarsorteos() {
        var tabla = document.querySelector("tbody");
        var cantidaddeelementosantes = tabla.children.length;
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiSorteos.php');
        cargaDatos.send()
        cargaDatos.onload = function() {
            const sorteos = JSON.parse(this.responseText);

            if (cantidaddeelementosantes - 1 != sorteos.length) {
    tabla.innerHTML = "<tr><th>ID</th><th>Premio</th><th>Cantidad</th><th>Fecha de realización</th><th>Acción</th></tr>"
    sorteos.forEach(cadaSorteo => {
        var linea = document.createElement("tr");

        function agregaralinea(dato) {
            var objeto = document.createElement("td");
            objeto.innerHTML = dato;
            linea.appendChild(objeto);
        }

        agregaralinea(cadaSorteo.ID_SORTEO);
        agregaralinea(cadaSorteo.Premio);
        agregaralinea(cadaSorteo.Cantidad);
        agregaralinea(cadaSorteo.Fecha_realización);
        agregaralinea('<img ruta="eliminar.php?tipo=sorteo&id=' + cadaSorteo.ID_SORTEO + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificar/modificarsorteo.php?id=' + cadaSorteo.ID_SORTEO + '"><img src="imagenes/acciones/editar.png" class="accion"></a>');
        
        tabla.appendChild(linea);
    })
    asignarbotoneliminar();
            }


        }
    }
</script>

</html>