<?php 
//agregar la actualizacion de foto y hacer logica de modificar contraseña, tambien hacer que se carguen los estilos de cada usuario en el style.css
        include("../chequeodelogin.php");
        include("../coneccionBD.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_SESSION["user"] != $_POST["usuario"]) { //si el nombre de usuario ingresados y el usuario actual son distintos
                $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";');//consulta para ver si está registrado el nuevo nombre de usuario
                if(mysqli_num_rows($checkuser) == 0){
                    $_SESSION["user"] = $_POST["usuario"];
                    $_SESSION["nombre"]= $_POST["nombre"];
                    //$_SESSION["fotoperf"]=
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                    echo "<script>alert('Usuario Actualizado')</script>";
                }else{
                    echo "<script>alert('Nombre de Usuario ya registrado')</script>";
                }

            }else{
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '";');
                echo "<script>alert('Usuario Actualizado')</script>";
            }
            

        }
        
        $consultausuario = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE Usuario ="' . $_SESSION["user"] . '";');
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
    <form method="POST" class="formularios">

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