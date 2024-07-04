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
    <?php include("barralateral.html") ?>
    <div class="buscador">
        <input type="text">
    </div>
    <div class="contenedordemenu">
        <table>
            <tr>
                <th>ID proveedor</th>
                <th>Razón social</th>
                <th>RUT</th>
                <th>telefono</th>
                <th>Acción</th>
            </tr>
            <tbody>
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
            </tbody>
        </table>
        <input type="button" value="+" class="agregardato">
    </div>
</body>

</html>