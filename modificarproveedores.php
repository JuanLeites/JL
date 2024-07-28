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
            <tr>
                <th>ID</th>
                <th>Razón social</th>
                <th>RUT</th>
                <th>telefono</th>
                <th>Acción</th>
            </tr>

            <tr>
                <td>1</td>
                <td>LUPF</td>
                <td>81243124141</td>
                <td>092211720</td>
                <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Empresa 2</td>
                <td>5151231231</td>
                <td>099362124</td>
                <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Empresa 3</td>
                <td>64123123</td>
                <td>47521563</td>
                <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
            </tr>
            <tr>
                <td>4</td>
                <td>Empresa 4</td>
                <td>1231312</td>
                <td>65123412</td>
                <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
            </tr>

        </table>

        <a href="agregarproveedores.php" class="agregardato">+</a>
        <!--  <button class="agregardato">-->
    </div>

</body>

<script>
    /*
    var botonabrir = document.querySelector(".agregardato");
    var botoncerrar = document.querySelector(".cerrarpopup");
    var popup = document.querySelector(".conenedordeagregador");
    botoncerrar.addEventListener("click", () => {
        popup.setAttribute("style", "display:none;");
    })
    botonabrir.addEventListener("click", () => {
        var popup = document.querySelector(".conenedordeagregador")
        popup.setAttribute("style", "");
    }) */
</script>

</html>