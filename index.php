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
    <title>Inicio de Sesión</title>
</head>
<link rel="stylesheet" href="css/style.css">
<script src="js/script.js"></script>

<body>

    <form method="POST" action="menuprincipal.php">
        <div class="contenedor">
            <h1>Iniciar Sesión</h1>
            <div class="subcont">
                <input <?php if (isset($_SESSION['bloq'])) {
                            echo "disabled";
                        } ?> type="text" name="usuario" placeholder="usuario"></input>
            </div>
            <div class="subcont">
            <input type="password" name="contraseña" id="contraseña" placeholder="contraseña"><img id='ver' src="imagenes/ojocerrado.png"></input>
            </div>
            <?php
            if (isset($_GET['causa'])) {
                switch ($_GET['causa']) {
                    case "err":
                        if (isset($_SESSION["intentos"])) { // la session está iniciada en el archivo "chequeodelogin.php"
                            echo "<p>contraseña o usuario incorrectos <br> " . $_SESSION["intentos"] + 1  . " intentos restantes</p>";
                        }
                        break;;
                    case "reg":
                        echo '<script>alert("!! registrado con exito ¡¡")</script>';
                        break;;
                    case "bloq":
                        echo '<p>Usuario bloqueado</p>';
                        break;;
                    case "textovacio":
                        echo '<p>debe completar los campos</p>';
                        break;;
                    case "nolog":
                        echo '<p>debes logearte para poder acceder al menu</p>';
                        break;;

                    case "sesioncerrada":
                        echo '<p>Secion cerrada con exito</p>';
                        break;;
                }
            }
            ?>
            <br>
            <input type="submit" value="Iniciar Sesión"></input>
            <hr id="linea">
            <h4>¿No Tienes Cuenta?<h4>
                    <a href="registro.php" class="linkk">registrar usuario</a>
            <h4>¿has olvidado tu contraseña?</h4>
                    <a href="meolvide.php" class="linkk">recuperar contraseña</a>

        </div>
        </div>
    </form>
    <?php include("footer.html") ?>
</body>

</html>