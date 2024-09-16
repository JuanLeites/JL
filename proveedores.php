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
    import {asignarbotoneliminar} from "./js/funciones.js"
    window.onload = () => {
        cargarproveedores()
        setInterval(() => {
            cargarproveedores()
        }, 2000);
    }

    function cargarproveedores() {
        var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
        var cantidaddeelementosantes = tabla.children.length; // guanta en la variable la cantidad de elementos "hijos" tiene la tabla

        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproveedores.php'); //consulta a la api
        cargaDatos.send()
        cargaDatos.onload = function() {
            const proveedores = JSON.parse(this.responseText);

            if (cantidaddeelementosantes - 1 != proveedores.length) { // compara los elementos de la tabla con los resultados de la api, si hay una cantidad distinta, cargará todos los proveedores
                tabla.innerHTML = "<tr><th>ID</th><th>Razón social</th><th>RUT</th><th>Contacto</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
                proveedores.forEach(cadaproveedor => {

                    var linea = document.createElement("tr");

                    function agregaralinea(dato) {
                        var objeto = document.createElement("td");
                        objeto.innerHTML = dato;
                        linea.appendChild(objeto);
                    }
                    agregaralinea(cadaproveedor.ID_PROVEEDOR)
                    agregaralinea(cadaproveedor.Razón_Social);
                    agregaralinea(cadaproveedor.RUT);
                    agregaralinea(cadaproveedor.Contacto);
                    agregaralinea('<img ruta="eliminar.php?tipo=proveedor&id=' + cadaproveedor.ID_PROVEEDOR + '" src="imagenes/acciones/borrar.png" class="accion eliminar"></a><a href="modificar/modificarproveedor.php?id=' + cadaproveedor.ID_PROVEEDOR + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')//guardamos en la imagen un atributo ruta con el tipo de elemento que es y con su id unica para luego poder utilizarlos
                    tabla.appendChild(linea);

                })
                asignarbotoneliminar();//llamamos a la funcion luego de haber cargado todos las filas.
            }


        }
    }

</script>

</html>