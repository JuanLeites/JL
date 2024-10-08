<?php
include("chequeodelogin.php");
include("coneccionBD.php");
include("funciones.php");

//en todos los casos posbiles guardamos lo que pasa en la variable "$opcion" para luego mostrar un mensaje despues que se carga el html
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["usuario"] != $_POST["usuario"]) { //si el nombre de usuario ingresados y el usuario actual son distintos
        $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";'); //consulta para ver si está registrado el nuevo nombre de usuario
        if (mysqli_num_rows($checkuser) == 0) { // si no hay ningun usuario con ese mismo nombre de usuario
            if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
                @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] .  '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
                    $_SESSION["fotoperf"] = $_POST["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                } else { //si la foto no existe
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                    $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                }
                $_SESSION["usuario"] = $_POST["usuario"]; //guardamos los nuevos datos en las variables 
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "usuarioyfotocambiados";
            } else { // si no se subió una foto pero si se cambió el usuario
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] .  '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "usuariocambiado";
            }
        } else { // si llegase a haber un usuario con ese mismo nombre
            if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") {
                @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe, la carga con el nombre de usuario también
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name']);
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name'];
                } else { //y si no existe, la carga normal
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                }
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "datosyfotocambiadosusuarioyaregistrado";
            } else {
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "datosactualizadosusuarioyaregistrado";
            }
        }
    } else { // si no se cambia el nombre de usuario
        if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { // si se cargó una foto
            @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
            if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { // si ya existe una foto con el mismo nombre foto
                move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta con el nombre de usuario
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name'];
            } else {
                move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
            }
            $_SESSION["nombre"] = $_POST["nombre"];
            $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];

            $opcion = "datosyfotoactualizada";
        } else {

            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
            $_SESSION["nombre"] = $_POST["nombre"];
            $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
            $opcion = "datosactualizados";
        }
    }
} else {
    $opcion = "";
}


//la consulta para cargar los datos en la pagina la hacemos luego de cualquier modificación
$consultausuario = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
    ?>
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">
    
    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
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
    <a href="menuprincipal.php" id="reg">regresar</a>
</body>

</html>

<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'usuarioyfotocambiados';
        mostraravisoconfoto("Usuario Modificado a " . $_SESSION["usuario"] . " y foto actualizada con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariocambiado';
        mostraraviso('Usuario Modificado a ' . $_SESSION["usuario"], $colorfondo, $colorprincipal);
        break;
    case 'datosyfotocambiadosusuarioyaregistrado';
        mostraravisoconfoto("Nombre de Usuario ya registrado, pero datos modificados y foto actualizada con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizadosusuarioyaregistrado';
        mostraraviso("Nombre de Usuario ya registrado, pero datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosyfotoactualizada';
        mostraravisoconfoto("Datos modificados y foto actualizada con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizados';
        mostraraviso("Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
}
?>