<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!--
    <div class="conenedordeagregador" style="">
        <h1>Agregar Proveedores</h1>
        <input type="text" placeholder="Razón Social" name="RS">
        <input type="number" placeholder="RUT" name="rut">
        <input type="number" placeholder="telefono">
        <input type="submit">
        <button class="cerrarpopup">X</button>
    </div> 
    -->

    <?php include("barralateral.html") ?>
    <div class="buscador">
        <input type="text" placeholder="Buscar proveedores">
    </div>

    <div class="contenedordemenu">
        <table>
            <tbody>
                
            </tbody>
        </table>
        <a href="agregarproveedores.php" class="agregardato">+</a>

    </div>

</body>

<script>
window.onload = () => {
    cargarproveedores()
    setInterval(()=>{cargarproveedores()},2000);
}
    function cargarproveedores() {
        var tabla = document.querySelector("tbody"); // guarda en la variable tabla el objeto de la tabla de html
        var cantidaddeelementosantes = tabla.children.length; // guanta en la variable la cantidad de elementos "hijos" tiene la tabla

        const cargaDatos = new XMLHttpRequest();
        cargaDatos.open('GET', 'apis/apiproveedores.php');//consulta a la api
        cargaDatos.send()
        cargaDatos.onload = function() {
            const proveedores = JSON.parse(this.responseText);

            if (cantidaddeelementosantes - 1 != proveedores.length) {// compara los elementos de la tabla con los resultados de la api, si hay una cantidad distinta, cargará todos los proveedores
                tabla.innerHTML="<tr><th>ID</th><th>Razón social</th><th>RUT</th><th>telefono</th><th>Acción</th></tr>"; // carga la primera fila de la tabla
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
                    agregaralinea('<a href="eliminarproveedor?id='+cadaproveedor.ID_PROVEEDOR+'"><img src="imagenes/acciones/borrar.png" class="accion eliminarprov"></a><a href="modificarproveedor?id='+cadaproveedor.ID_PROVEEDOR+'"><img src="imagenes/acciones/editar.png" class="accion"></a>')
                    tabla.appendChild(linea);

                })
            }


        }
    }
</script>

</html>