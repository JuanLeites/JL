<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
$consultausuario = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_SESSION["user"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Contraseña</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../imagenes/LUPF.svg" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">

        <label for="contraseñavieja">Ingrese su contraseña Acutal</label>
        <input type="password" name="contraseñavieja" id="contraseñavieja">
        <img class="ojoindex" id='ver' src="../imagenes/ojocerrado.png">

        <hr id="linea">

        <label for="contraseñanueva">Ingrese Contraseña nueva</label>
        <input type="password" name="contraseñanueva" id="contraseñanueva">
        <img class="ojoindex" id='ver' src="../imagenes/ojocerrado.png">

        <label for="contraseñanueva2">Repita Contraseña nueva</label>
        <input type="password" name="contraseñanueva2" id="contraseñanueva2">
        <img class="ojoindex" id='ver' src="../imagenes/ojocerrado.png">
        <input type="submit" value="Cambiar">
    </form>
    <a href="../menuprincipal.php" id="reg">regresar</a>
</body>

</html>