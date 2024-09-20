<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["usuario"] != $_POST["usuario"]) { //si el nombre de usuario ingresados y el usuario actual son distintos
        $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";'); //consulta para ver si está registrado el nuevo nombre de usuario
        if (mysqli_num_rows($checkuser) == 0) { // si no hay ningun usuario con ese mismo nombre de usuario
            if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se subió una foto
                @unlink("../fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                if (file_exists('/..fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe, la carga con el nombre de usuario también
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] . '";');
                } else {
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] . '";');
                }
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                echo "<script>alert('Usuario Actualizado a " . $_SESSION["usuario"] . " y foto actualizada')</script>"; 
            } else { // si no se subió una foto pero si se cambió el usuario
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["nombre"] = $_POST["nombre"];
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                echo "<script>alert('Usuario Actualizado a " . $_SESSION["usuario"] . "')</script>";
            }
        } else { // si llegase a haber un usuario con ese mismo nombre
            if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") {
                @unlink("../fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                if (file_exists('/..fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe, la carga con el nombre de usuario también
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']);
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                } else { //y si no existe, la carga normal
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                }
                echo "<script>alert('Nombre de Usuario ya registrado, pero datos y foto actualizado')</script>"; // pero datos actualizados

            } else {
                $_SESSION["nombre"] = $_POST["nombre"];
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                echo "<script>alert('Nombre de Usuario ya registrado, pero datos actualizados')</script>"; // pero datos actualizados sin foto
            }
        }
    } else { // si no se cambia el nombre de usuario
        if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") {
            @unlink("../fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
            $_SESSION["nombre"] = $_POST["nombre"];
            $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
            if (file_exists('/..fotoperfil/' . $_FILES['fotoperfil']['name'])) {
                move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_SESSION["uisuario"] . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["uisuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
            } else {
                move_uploaded_file($_FILES['fotoperfil']['tmp_name'], '../fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
            }
            echo "<script>alert('datos y foto actualizados')</script>"; // pero datos actualizados
        } else {
            $_SESSION["nombre"] = $_POST["nombre"];
            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
            echo "<script>alert('datos actualizados')</script>"; // pero datos actualizados sin foto

        }
    }
}
$consultausuario = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../imagenes/LUPF.svg" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios" enctype="multipart/form-data">

        <label for="usuario">usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario['Usuario']; ?>">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $usuario['Nombre']; ?>">

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" max="2019-12-31" min="1940-12-31" value="<?php echo $usuario['Fecha_Nacimiento']; ?>">

        <label for="correo">Correo</label>
        <input type="email" name="correo" id="correo" value="<?php echo $usuario['Correo']; ?>">

        <label for="fotoperfil">Foto de Perfil</label>
        <input type="file" name="fotoperfil" id="fotoperfil" accept="image/*">


        <input type="submit" value="Actualizar">
    </form>
    <a href="../menuprincipal.php" id="reg">regresar</a>
</body>

</html>