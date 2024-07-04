<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar clientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("barralateral.html") ?>
    <div class="buscador">
        <input type="text" placeholder="Buscar Clientes">
    </div>
    <div class="contenedordemenu">
        <table>
            <tr>
                <th>ID cliente</th>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Deuda</th>
                <th>Fecha de Nacimiento</th>
                <th>Tickets de sorteo</th>
                <th>contacto</th>
                <th>accion</th>
            </tr>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>56752611</td>
                    <td>Juan Leites</td>
                    <td>0</td>
                    <td>2005-10-02</td>
                    <td>1</td>
                    <td>092211720</td>
                    <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
                </tr>
                <tr>
                <tr>
                    <td>2</td>
                    <td>99999999</td>
                    <td>Benjita Ojedita</td>
                    <td>1000</td>
                    <td>2006-2-xx</td>
                    <td>0</td>
                    <td>099999999</td>
                    <td><a href="eliminar"><img src="imagenes/acciones/borrar.png" class="accion"></a><a href="modificar"><img src="imagenes/acciones/editar.png" class="accion"></a></td>
                </tr>
                <tr>
            </tbody>
        </table>
        <a href="agregarclientes.php" class="agregardato">+</a>
    </div>
</body>

</html>