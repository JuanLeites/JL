<?php
include_once("coneccionBD.php");
if (!file_exists("fotoperfil")) {
    mkdir("fotoperfil");
}
$configuracion = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Clave_Maestra FROM Configuración')); //obtenemos la clave maestra del software que está guardada en la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["nombre"] == "" || $_POST["usuario"] == "" || $_POST["pass"] == "" || $_POST["pass2"] == "" || $_POST["correo"] == "" || $_POST["fecha"] == ""  || $_POST["clavamaestra"] == "") { //si alguno está vacío
        header('Location:registro.php?causa=campovacio&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' .  $_POST["fecha"]);
        die();
    }
    if ($_POST["pass"] != $_POST["pass2"]){// si las contraseñas no coinciden da error.
        header('Location:registro.php?causa=contraseñasdistintas&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' .  $_POST["fecha"]);
        die();
    }
    if (strlen($_POST["pass"]) < 6) {//si coinciden pero son tienen menos de 6 caracteres.
        header('Location:registro.php?causa=contraseñacorta&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' .  $_POST["fecha"]);
        die();
    }
    if ($_POST["clavamaestra"] != $configuracion["Clave_Maestra"]) { //si la clave maestra está mal.
        header('Location:registro.php?causa=clavemaestram&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' .  $_POST["fecha"]);
        die();
    } 
             
    $chekuser = mysqli_query($basededatos, 'SELECT * from Usuario WHERE Usuario="' . $_POST["usuario"] . '"'); //consulta para comprobar que no haya ningun usuario con ese usuario
    $chekcorreo = mysqli_query($basededatos, 'SELECT * from Usuario WHERE Correo="' . $_POST["correo"] . '"'); //consulta para comprobar que no haya ningun usuario con ese correo

    if (mysqli_num_rows($chekuser) == 1) { //si encuentra un usuario con ese mismo usuario.
        header('Location:registro.php?causa=usuarioyaregistrado&nombre=' . $_POST["nombre"] . '&correo=' . $_POST["correo"] . '&fecha=' .  $_POST["fecha"]);
        die();
    }
    if (mysqli_num_rows($chekcorreo) == 1) {
        header('Location:registro.php?causa=correoyaregistrado&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&fecha=' .  $_POST["fecha"]);
        die();
    }

    if($_FILES["fotoperfil"]["tmp_name"] == ""){//si no carga una foto
        mysqli_query($basededatos, 'INSERT INTO Usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . password_hash($_POST["pass"], PASSWORD_BCRYPT) . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","perfilpordefecto.png","' . $_POST["fecha"] . '");'); //password_hash()encripta la contraseña, recive como parametro la contraseña para encriptar y  el algoritmo 
        header("Location:index.php?causa=reg");
        die();
    }else{
        if (!file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si no existe ninguna foto con ese nombre se guardara la foto en la carpeta foto de perfil
            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']);
            mysqli_query($basededatos, 'INSERT INTO Usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . password_hash($_POST["pass"], PASSWORD_BCRYPT) . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","' . $_FILES['fotoperfil']['name'] . '","' . $_POST["fecha"] . '");'); //password_hash()encripta la contraseña, recive como parametro la contraseña para encriptar y  el algoritmo 
            header("Location:index.php?causa=reg");
        } else { //sino la guardara con el nombre de usuario(unico)y el nombre de la foto
            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']);
            mysqli_query($basededatos, 'INSERT INTO Usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . password_hash($_POST["pass"], PASSWORD_BCRYPT) . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '","' . $_POST["fecha"] . '");');
            header("Location:index.php?causa=reg");
        }
    }
    
          
}         

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate!</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">
</head>

<body class="scroll">

    <form method="POST" class="contenedor" enctype="multipart/form-data">
        <h1>Registrar usuario</h1>
        <div class="contenedordesubcontenedores">
            <div class="subcontenedores">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingrese su nombre" <?php if (isset($_GET["nombre"])) {
                                                                                                    echo "value='" . $_GET["nombre"] . "'";
                                                                                                } ?> required>
                <label for="usuario">Usuario</label>
                <input id="usuario" type="text" name="usuario" placeholder="Ingrese su usuario" <?php if (isset($_GET["usuario"])) {
                                                                                                    echo "value='" . $_GET["usuario"] . "'";
                                                                                                } ?> required>
                <label for="contra1">Contraseña</label>
                <input id="contra1" type="password" class="contraseña1register" name="pass" placeholder="Ingrese contraseña" minlength="6" required><img class="ojo1register" id='ver' src="imagenes/ojocerrado.png">
                <label for="contra2">Repita contraseña</label>
                <input id="contra2" type="password" class="contraseña2register" name="pass2" placeholder="Repita contraseña" minlength="6" required><img class="ojo2register" id='ver' src="imagenes/ojocerrado.png">
            </div>

            <div class="subcontenedores ">
                <label for="correo">Correo electrónico</label>
                <input id="correo" type="email" name="correo" placeholder="Ingrese su correo" required <?php if (isset($_GET["correo"])) {
                                                                                                    echo "value='" . $_GET["correo"] . "'";
                                                                                                } ?>>
                <label for="fecha" style="margin-top: 1px;">Fecha de nacimiento</label>
                <input id="fecha" type="date" max="2020-01-01" name="fecha" required <?php if (isset($_GET["fecha"])) {
                                                                                echo "value='" . $_GET["fecha"] . "'";
                                                                            } ?>>
                <label for="fotoperf">Foto de perfil</label>
                <input id="fotoperf" type="file" name="fotoperfil" accept="image/*">

                <label for="clavemaestra" style="margin-top: 18px;">Clave maestra</label>
                <input id="clavemaestra" type="password" name="clavamaestra" placeholder="clave maestra" required>
            </div>
        </div>

        <?php
        if (isset($_GET["causa"])) {
            switch ($_GET['causa']) {
                case "usuarioyaregistrado":
                    echo "<p>Nombre de usuario ya registrado</p>";
                    break;;
                case "correoyaregistrado":
                    echo "<p>Correo ya registrado</p>";
                    break;;
                case "contraseñasdistintas":
                    echo '<p>Las contraseñas no coinciden</p>';
                    break;;
                case "campovacio":
                    echo '<p>Debes de rellenar todos los campos</p>';
                    break;;
                case "contraseñacorta":
                    echo '<p>la contraseña debe de tener al menos 6 caracteres</p>';
                    break;;
                case "clavemaestram":
                    echo '<p>Clave Maestra Incorrecta!</p>';
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
    <?php include_once("footer.html") ?>
    <?php include("barraarriba.html") ?>
</body>
<script src="js/funcionessinexport.js"></script>

</html>