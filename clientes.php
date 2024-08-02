<?php
include("chequeodelogin.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar clientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="buscador">
        <input type="text" placeholder="Buscar Clientes">
    </div>
    <div class="contenedordemenu">
        <table>
            <tbody>
            </tbody>
        </table>
        <a href="agregarclientes.php" class="agregardato">+</a>
    </div>
    <?php include("barralateral.html") ?>
</body>
<script>
    window.onload = () => {
        cargarclientes()
        setInterval(() => {
            cargarclientes()
        }, 2000);
    }


    function cargarclientes() {
        var tabla = document.querySelector("tbody");
        var cantidaddeelementosantes = tabla.children.length;
        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiclientes.php');
        cargaDatos.send()
        cargaDatos.onload = function() {
            const clientes = JSON.parse(this.responseText);

            if (cantidaddeelementosantes - 1 != clientes.length) {

                tabla.innerHTML = "<tr><th>ID</th><th>Cedula</th><th>Nombre</th><th>Deuda</th><th>Fecha de Nacimiento</th><th>Bouchers</th><th>contacto</th><th>RUT</th><th>accion</th></tr>"
                clientes.forEach(cadacliente => {

                    var linea = document.createElement("tr");

                    function agregaralinea(dato) {
                        var objeto = document.createElement("td");
                        objeto.innerHTML = dato;
                        linea.appendChild(objeto);
                    }

                    agregaralinea(cadacliente.ID_CLIENTE);
                    agregaralinea(cadacliente.Cédula);
                    agregaralinea(cadacliente.Nombre);
                    agregaralinea(cadacliente.Deuda);
                    agregaralinea(cadacliente.Fecha_de_Nacimiento);
                    agregaralinea(cadacliente.Tickets_de_Sorteo);
                    agregaralinea(cadacliente.Contacto);
                    agregaralinea(cadacliente.RUT);
                    agregaralinea('<a href="eliminarcliente?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/borrar.png" class="accion eliminarcli"></a><a href="modificarcliente?id=' + cadacliente.ID_CLIENTE + '"><img src="imagenes/acciones/editar.png" class="accion"></a>')
                    tabla.appendChild(linea);

                })
            }


        }
    }
</script>

</html>