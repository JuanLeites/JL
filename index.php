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
            <h3>Iniciar Sesión</h3>
            <input <?php if (isset($_SESSION['bloq'])) {
                        echo "disabled";
                    } ?> type="text" name="usuario" placeholder="usuario"></input>
            <input type="password" name="contraseña" id="contraseña" placeholder="contraseña"><img id='ver' src="imagenes/ojocerrado.png"></input>
            <?php
            session_start();
            if (isset($_GET['causa'])) {
                switch ($_GET['causa']) {
                    case "err":
                        if (isset($_SESSION["intentos"])) {
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
            <hr>
            <h5>¿No Tienes Cuenta?<h5>
                    <a href="registro.php" class="linkk">registrar usuario</a>
        </div>
        </div>
    </form>
    <?php include("footer.php") ?>
</body>

</html>