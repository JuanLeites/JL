<?php
session_start();
if (isset($_SESSION["usuario"])) { //si ya están las variables de session nos mandara al menu principal
    header("Location:menuprincipal.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">
    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <title>Inicio de Sesión</title>
</head>

<body class="scroll">
    <?php include("barraarriba.html") ?>
    <form method="POST" class="contenedor" action="menuprincipal.php">
        <h1>Iniciar Sesión</h1>
        <input <?php if (isset($_SESSION['bloq'])) {
                    echo "disabled";
                } // si está seteada la variable de session bloq, desabilitamos el botón 
                ?> type="text" name="usuario" placeholder="usuario"></input>
        <input <?php if (isset($_SESSION['bloq'])) {
                    echo "disabled";
                } ?> type="password" name="contraseña" class="contraseñadeindex" placeholder="contraseña"><img class="ojoindex" id='ver' src="imagenes/ojocerrado.png"></input>

        <?php
        include_once("funciones.php");

        if (isset($_GET['causa'])) {
            switch ($_GET['causa']) {
                case "err":
                    if (isset($_SESSION["intentosdisponibles"])) { // la session está iniciada en el archivo "chequeodelogin.php"
                        echo "<p>Contraseña o usuario incorrectos <br> " . $_SESSION["intentosdisponibles"] + 1  . " intentos restantes</p>";
                    }
                    break;;
                case "reg":
                    mostraraviso("Registrado con éxito!", "", "");
                    break;;
                case "bloq":
                    mostraralerta("Usuario Bloqueado!", "", "");
                    break;;
                case "textovacio":
                    mostraralerta("Debes de completar todos los campos", "", "");
                    break;;
                case "nolog":
                    mostraralerta("Debes estar logeado para poder acceder al menu.", "", "");
                    break;;
                case "sesioncerrada":
                    mostraraviso("Sesión cerrada con éxito", "", "");
                    break;;
                case "usuarioinexistente":
                    mostraralerta("Ese usuario no existe", "", "");
                    break;;
                case "contraseñaactualizada":
                    mostraraviso("Contraseña Actualizada con éxito!", "", "");
                    break;;
                case "nohagastrampa":
                    mostraralerta("No trates de acceder a apartados que no puedes!", "", "");
                    break;;
                case "intentosagotados":
                    mostraralerta("Has exedido el limite de intentos para ingresar el código para reestablecer tu contraseña", "", "");
                    break;;
            }
        }
        ?>
        <br>
        <input <?php if (isset($_SESSION['bloq'])) {
                    echo "disabled";
                } ?> type="submit" value="Iniciar Sesión"></input>
        <hr id="linea">
        <h4>¿No Tienes Cuenta?</h4>
        <a href="registro.php" class="linkk">registrar usuario</a>
        <h4>¿has olvidado tu contraseña?</h4>
        <a href="meolvidecontraseña/meolvide.php" class="linkk">recuperar contraseña</a>
    </form>
    <?php include_once("footer.html") ?>
</body>
<script src="js/funciones.js" type="module"></script>

</html>