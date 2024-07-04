<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("barralateral.html") ?>
    <div class="buscador">
        <input type="text">
    </div>
    <div class="contenedordemenu">
        <table>
            <tr>
                <th>ID Producto</th>
                <th>nombre</th>
                <th>codigo de barras</th>
                <th>descripcion</th>
                <th>marca</th>
                <th>cantidad</th>
                <th>categoria</th>
                <th>iva</th>
                <th>accion</th>
            </tr>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>jabon</td>
                    <td>110031211</td>
                    <td>jabon con olor a tuco color verde</td>
                    <td>Rexona</td>
                    <td>4</td>
                    <td>Limpieza</td>
                    <td>Basico</td>
                    <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Pasta colgate</td>
                    <td>41241211</td>
                    <td>Pasta de 200g</td>
                    <td>Colgate</td>
                    <td>10</td>
                    <td>Salud</td>
                    <td>Basico</td>
                    <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
                </tr>
                
                
            </tbody>
        </table>
        <input type="button" value="+" class="agregardato">
    </div>
</body>

</html>