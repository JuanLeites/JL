<?php 
session_start();
if (isset($_SESSION["user"]) && isset($_SESSION["pass"])){//si ya están las variables de session nos mandara al menu principal
    header("Location:menuprincipal.php");
}
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="imagenes/LUPF.svg" type="image/x-icon">
    <title>Inicio de Sesión</title>
</head>

<body class="scroll">

    <form method="POST" class="contenedor" action="menuprincipal.php">
            <h1>Iniciar Sesión</h1>
                <input <?php if (isset($_SESSION['bloq'])) {
                            echo "disabled";
                        } ?> type="text" name="usuario" placeholder="usuario"></input>
            <input type="password" name="contraseña" class="contraseñadeindex" placeholder="contraseña"><img class="ojoindex" id='ver' src="imagenes/ojocerrado.png"></input>

            <?php
            if (isset($_GET['causa'])) {
                switch ($_GET['causa']) {
                    case "err":
                        if (isset($_SESSION["intentos"])) { // la session está iniciada en el archivo "chequeodelogin.php"
                            echo "<p>Contraseña o usuario incorrectos <br> " . $_SESSION["intentos"] + 1  . " intentos restantes</p>";
                        }
                        break;;
                    case "reg":
                        echo '<script>alert("!! registrado con exito ¡¡")</script>';
                        break;;
                    case "bloq":
                        echo '<p>Usuario bloqueado</p>';
                        break;;
                    case "textovacio":
                        echo '<p>Debes completar todos los campos</p>';
                        break;;
                    case "nolog":
                        echo '<p>Debes logearte para poder acceder al menu</p>';
                        break;;

                    case "sesioncerrada":
                        echo '<p>Sesión cerrada con exito</p>';
                        break;;
                }
            }
            ?>
            <br>
            <input type="submit" value="Iniciar Sesión"></input>
            <hr id="linea">
            <h4>¿No Tienes Cuenta?</h4>
                    <a href="registro.php" class="linkk">registrar usuario</a>
            <h4>¿has olvidado tu contraseña?</h4>
                    <a href="meolvide.php" class="linkk">recuperar contraseña</a>
    </form>
    <?php include("footer.html") ?>
</body>
<script src="js/funciones.js" type="module"></script>
</html>