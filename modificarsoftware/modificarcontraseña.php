<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
$consultausuario = mysqli_query($basededatos, 'SELECT * FROM usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["contraseñavieja"]) && isset($_POST["contraseñanueva"]) && isset($_POST["contraseñanueva2"])) { //si estan seteados los valores
        if ($_POST["contraseñavieja"] != "" && $_POST["contraseñanueva"] != "" && $_POST["contraseñanueva2"] != "") { //si no estan vacios
            if ($_POST["contraseñanueva"] == $_POST["contraseñanueva2"]) {
                if ($_POST["contraseñavieja"] == $usuario["Contraseña"]) { // si la contraseña ingresada coincide con la contraseña del usuario
                    if (strlen($_POST["contraseñanueva"]) > 5) { //strlen retorna la cantidad de caracteres
                        $_SESSION["contraseña"] = $_POST["contraseñanueva2"];
                        mysqli_query($basededatos, 'UPDATE `usuario` SET `contraseña`="' . $_POST["contraseñanueva2"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        echo "<script>alert('contraseña cambiada con éxito  ')</script>";
                    } else {
                        echo "<script>alert('la contraseña debe de tener minimo 6 caracteres')</script>";
                    }
                } else {
                    echo "<script>alert('la contraseña que has ingresado no es correcta')</script>";
                }
            } else {
                echo "<script>alert('las contraseñas nuevas no coinciden')</script>";
            }
        } else {
            echo "<script>alert('debe de rellenar todos los campos de texto')</script>";
        }
    }
}
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
        <input class="inputpass1" type="password" name="contraseñavieja" id="contraseñavieja">
        <img class="ojo1" id='ver' src="../imagenes/ojocerrado.png">

        <hr id="linea">

        <label for="contraseñanueva">Ingrese Contraseña nueva</label>
        <input class="inputpass2" type="password" name="contraseñanueva" id="contraseñanueva">
        <img class="ojo2" id='ver' src="../imagenes/ojocerrado.png">

        <label for="contraseñanueva2">Repita Contraseña nueva</label>
        <input class="inputpass3" type="password" name="contraseñanueva2" id="contraseñanueva2">
        <img class="ojo3" id='ver' src="../imagenes/ojocerrado.png">
        <input type="submit" value="Cambiar">
    </form>
    <a href="../menuprincipal.php" id="reg">regresar</a>
</body>
<script src="../js/funciones.js" type="module"></script>

</html>