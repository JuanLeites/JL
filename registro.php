<?php
include("coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["usuario"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["correo"])) {
        if ($_POST["nombre"] != "" && $_POST["usuario"] != "" && $_POST["pass"] != "" && $_POST["pass2"] != "" && $_POST["correo"] != "") { //si no están vacíos
            if ($_POST["pass"] == $_POST["pass2"]) { //chequea que las dos contraseñas sean iguales
                if (strlen($_POST["pass"]) >= 6) {//si la cantidad de caracteres de la contraseña es mayor o igual a 6
                    $chek = mysqli_query($basededatos, 'SELECT * from usuario WHERE usuario="' . $_POST["usuario"] . '"');
                    if (mysqli_num_rows($chek) == 0) {//si no encuentra ningun usuario con ese nombre
                        mysqli_query($basededatos, 'INSERT INTO usuario (usuario, contraseña, correo, nombre) VALUES ("' . $_POST["usuario"] . '","' . $_POST["pass"] . '","' . $_POST["correo"] . '","' . $_POST["nombre"] . '");');
                        header("Location:index.php?causa=reg");
                    } else {
                        header('Location:registro.php?causa=yaregistrado');
                    }
                } else {
                    header('Location:registro.php?causa=contraseñacorta');
                }
            } else {
                header('Location:registro.php?causa=contraseñasdistintas&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"]);
            }
        } else { //si llega a estar un campo vacío
            header('Location:registro.php?causa=campovacio&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"]);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarme</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/register.png" type="image/x-icon">

</head>

<body>
    <form method="POST">
        <div class="conte">
            <h2>Registrar usuario</h2>
            <input type="text" name="nombre" placeholder="Ingrese su nombre" <?php if (isset($_GET["nombre"])) {
                                                                                    echo "value='" . $_GET["nombre"] . "'";
                                                                                } ?>>
            <input type="text" name="usuario" placeholder="Ingrese su usuario" <?php if (isset($_GET["usuario"])) {
                                                                                    echo "value='" . $_GET["usuario"] . "'";
                                                                                } ?>>
            <input type="password" name="pass" placeholder="Ingrese contraseña">
            <input type="password" name="pass2" placeholder="Repita contraseña">
            <input type="email" name="correo" placeholder="Ingrese su correo" <?php if (isset($_GET["correo"])) {
                                                                                    echo "value='" . $_GET["correo"] . "'";
                                                                                } ?>>
            <?php
            if (isset($_GET["causa"])) {
                switch ($_GET['causa']) {
                    case "yaregistrado":
                        echo "<p>ese nombre de usuario ya está registrado</p>";
                        break;;
                    case "contraseñasdistintas":
                        echo '<p>las contraseñas no coinciden</p>';
                        break;;
                    case "campovacio":
                        echo '<p>debes de rellenar todos los campos</p>';
                        break;;
                    case "contraseñacorta":
                        echo '<p>la contraseña debe de tener al menos 6 caracteres</p>';
                        break;;
                }
            }
            ?>
            <input type="submit" class="bot" value="Registrarme">
            <hr>
            <br>
            <h5>¿Ya Tienes Cuenta?<h5>
                    <a href="index.php" class="linkk">Iniciar Sesión</a>
        </div>

    </form>
</body>

</html>