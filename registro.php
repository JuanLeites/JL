<?php
include("coneccionBD.php");
if (!file_exists("fotoperfil")) {
    mkdir("fotoperfil");
}

$clavemaestra = "lupf2024"; //asignamos clave maestra del software

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["usuario"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["correo"]) && isset($_POST["fecha"]) && isset($_FILES["fotoperfil"]) && isset($_POST["clavamaestra"])) {
        if ($_POST["nombre"] != "" && $_POST["usuario"] != "" && $_POST["pass"] != "" && $_POST["pass2"] != "" && $_POST["correo"] != "" && $_POST["fecha"] != "" && $_FILES["fotoperfil"]["tmp_name"] != "" && $_POST["clavamaestra"] != "") { //si no están vacíos
            if ($_POST["pass"] == $_POST["pass2"]) { //chequea que las dos contraseñas sean iguales

                if (strlen($_POST["pass"]) >= 6) { //si la cantidad de caracteres de la contraseña es mayor o igual a 6
                    if($_POST["fecha"]<"2020-01-01"){
                        if ($_POST["clavamaestra"] == $clavemaestra) { //comparamos clave maestra para lograr el registro

                            $chek = mysqli_query($basededatos, 'SELECT * from usuario WHERE usuario="' . $_POST["usuario"] . '"');
    
                            if (mysqli_num_rows($chek) == 0) { //si no encuentra ningun usuario con ese nombre
    
                                if (!file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si no existe ninguna foto con ese nombre se guardara la foto en la carpeta foto de perfil
                                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']);
                                    mysqli_query($basededatos, 'INSERT INTO Usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . $_POST["pass"] . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","' . $_FILES['fotoperfil']['name'] . '","' . $_POST["fecha"] . '");');
                                    header("Location:index.php?causa=reg");
                                } else { //sino la guardara con el nombre de usuario(unico)y el nombre de la foto
                                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']);
                                    mysqli_query($basededatos, 'INSERT INTO usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . $_POST["pass"] . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '","' . $_POST["fecha"] . '");');
                                    header("Location:index.php?causa=reg");
                                }
                            } else {
                                header('Location:registro.php?causa=yaregistrado&nombre=' . $_POST["nombre"] . '&correo=' . $_POST["correo"].'&fecha='.$POST["fecha"]);
                            }
                        } else {
                            header('Location:registro.php?causa=clavemaestram&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"].'&fecha='.$POST["fecha"]);
                        }
                    }else{
                        header('Location:registro.php?causa=menor&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"]);
                    }


                } else {
                    header('Location:registro.php?causa=contraseñacorta&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"].'&fecha='.$POST["fecha"]);
                }
            } else {
                header('Location:registro.php?causa=contraseñasdistintas&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"].'&fecha='.$POST["fecha"]);
            }
        } else { //si llega a estar un campo vacío
            header('Location:registro.php?causa=campovacio&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"].'&fecha='.$POST["fecha"]);
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
    <script src="js/script.js">
        
    </script>
</head>

<body class="scroll">
    <form method="POST" class="contenedor" enctype="multipart/form-data">
        <h1>Registrar usuario</h1>
        <div class="contenedordesubcontenedores">
            <div class="subcontenedores">
                <input type="text" name="nombre" placeholder="Ingrese su nombre" <?php if (isset($_GET["nombre"])) {
                                                                                    echo "value='" . $_GET["nombre"] . "'";
                                                                                } ?>>
                <input type="text" name="usuario" placeholder="Ingrese su usuario" <?php if (isset($_GET["usuario"])) {
                                                                                    echo "value='" . $_GET["usuario"] . "'";
                                                                                } ?>>
                <input type="password" class="contraseña1register" name="pass" placeholder="Ingrese contraseña"><img class="ojo1register" id='ver' src="imagenes/ojocerrado.png">
                <input type="password" class="contraseña2register" name="pass2" placeholder="Repita contraseña"><img class="ojo2register" id='ver' src="imagenes/ojocerrado.png">
            </div>

            <div class="subcontenedores ">
                <input type="email" name="correo" placeholder="Ingrese su correo" <?php if (isset($_GET["correo"])) {
                                                                                    echo "value='" . $_GET["correo"] . "'";
                                                                                } ?>>
                <input type="date"  max="2019-12-31" name="fecha" <?php if (isset($_GET["fecha"])) {
                                                echo "value='" . $_GET["fecha"] . "'";
                                            } ?>>
                <input type="file" name="fotoperfil">
                <input type="password" name="clavamaestra" placeholder="clave maestra">
            </div>
        </div>
        
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
                    case "clavemaestram":
                        echo '<p>la clave maestra está mal</p>';
                        break;;
                    case "menor":
                        echo '<p>debes de haber nacido antes del 2020 para registrarte</p>';//mejorar
                        break;;
                }
            }
        ?>
        <input type="submit" value="Registrarme">
        <hr id="linea">
        <br>
        <h4>¿Ya Tienes Cuenta?</h4>
        <a href="index.php" class="linkk">Iniciar Sesión</a>
    </form>
    <?php include("footer.html") ?>
</body>
<script src="js/funciones.js" type="module"></script>
</html>