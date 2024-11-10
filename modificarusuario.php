<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

//en todos los casos posbiles guardamos lo que pasa en la variable "$opcion" para luego mostrar un mensaje despues que se carga el html

$opcion = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //cambiamos usuario
    if ($_SESSION["usuario"] != $_POST["usuario"]) {
        if(strlen($_POST["usuario"])>4){
            $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";'); //consulta para ver si está registrado el nuevo nombre de usuario
            if (mysqli_num_rows($checkuser) == 0) { // si no hay ningun usuario con ese mismo nombre de usuario o ese corro
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                $_SESSION["usuario"] = $_POST["usuario"];
                $opcion .= "usuariocambiado";
            } else {
                $opcion .= "usuarioyaexistente";
            }
        }else{
            $opcion.="usuariomuycorto";
        }
    
    }

    
    //cambiamos correo
    if ($_SESSION["correo"] != $_POST["correo"]) {
        $checkcorreo = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE  correo ="' . $_POST["correo"] . '";');
        if (mysqli_num_rows($checkcorreo) == 0) { //si no hay un correo así en la BD
            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
            $_SESSION["correo"] = $_POST["correo"];
            $opcion .= "correocambiado";
        } else {
            $opcion .= "correoyaexistente";
        }
    }
    //cambiamos la foto
    if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
        @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
        if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
            $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
        } else { //si la foto no existe
            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
            $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
        }
        $opcion .= "fotocambiada";
    }

    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
    $_SESSION["nombre"] = $_POST["nombre"];
    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];

   
    if($opcion==""){ //si no se hizo ningun cambio la variable opcion no se seteará
        $opcion = "datosactualizados";
    }else{//si se hizo, se le concatenará la opción
        $opcion .= "datosactualizados";
    }

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
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
    ?>
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
</head>

<body>
    <form method="POST" class="formularios" enctype="multipart/form-data">

        <label for="usuario">usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php echo $usuario['Usuario']; ?>" required>

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $usuario['Nombre']; ?>" required>

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" max="2019-12-31" min="1940-12-31" value="<?php echo $usuario['Fecha_Nacimiento']; ?>" required>

        <label for="correo">Correo</label>
        <input type="email" name="correo" id="correo" value="<?php echo $usuario['Correo']; ?>">

        <label for="fotoperfil">Foto de Perfil</label>
        <input type="file" name="fotoperfil" id="fotoperfil" accept="image/*">

        <input type="submit" value="Actualizar">
    </form>
    <a href="menuprincipal.php" id="reg">Regresar</a>
</body>

</html>

<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"

//hay que probar todos los posibles casos de combinaciones de cambios en la variable $opcion
//echo $opcion;
switch (trim($opcion)) {
    // CASO BASE
    case 'datosactualizados':
        mostraraviso("Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;

    // CASOS SOLO USUARIO
    case 'usuariocambiadodatosactualizados':
        mostraraviso("Usuario y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuarioyaexistentedatosactualizados':
        mostraraviso("Ese usuario ya está en uso!! <br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuariomuycortodatosactualizados':
        mostraraviso("El nombre de usuario es muy corto <br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;

    // CASOS SOLO CORREO
    case 'correocambiadodatosactualizados':
        mostraraviso("Correo y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'correoyaexistentedatosactualizados':
        mostraraviso("Ese correo ya está en uso!! <br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;

    // CASOS SOLO FOTO
    case 'fotocambiadadatosactualizados':
        mostraravisoconfoto("Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;

    // CASOS USUARIO + CORREO
    case 'usuariocambiadocorreocambiadodatosactualizados':
        mostraraviso("Usuario, correo y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuariocambiadocorreoyaexistentedatosactualizados':
        mostraraviso("Ese correo ya está en uso!! <br> Usuario y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuarioyaexistentecorreocambiadodatosactualizados':
        mostraraviso("El usuario ya existe!! <br> Correo y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuarioyaexistentecorreoyaexistentedatosactualizados':
        mostraraviso("Ese usuario y correo ya están en uso!! <br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuariomuycortocorreocambiadodatosactualizados':
        mostraraviso("El nombre de usuario es muy corto <br> Correo y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuariomuycortocorreoyaexistentedatosactualizados':
        mostraraviso("El nombre de usuario es muy corto y ese correo ya está en uso!! <br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;

    // CASOS USUARIO + FOTO
    case 'usuariocambiadofotocambiadadatosactualizados':
        mostraravisoconfoto("Usuario, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuarioyaexistentefotocambiadadatosactualizados':
        mostraravisoconfoto("El usuario ya existe!! <br> Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariomuycortofotocambiadadatosactualizados':
        mostraravisoconfoto("El nombre de usuario es muy corto <br> Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;

    // CASOS CORREO + FOTO
    case 'correocambiadofotocambiadadatosactualizados':
        mostraravisoconfoto("Correo, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'correoyaexistentefotocambiadadatosactualizados':
        mostraravisoconfoto("Ese correo ya está en uso!! <br> Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;

    // CASOS USUARIO + CORREO + FOTO
    case 'usuariocambiadocorreocambiadofotocambiadadatosactualizados':
        mostraravisoconfoto("Usuario, correo, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariocambiadocorreoyaexistentefotocambiadadatosactualizados':
        mostraravisoconfoto("El correo ya existe!! <br> Usuario, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuarioyaexistentecorreocambiadofotocambiadadatosactualizados':
        mostraravisoconfoto("El usuario ya existe!! <br> Correo, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuarioyaexistentecorreoyaexistentefotocambiadadatosactualizados':
        mostraravisoconfoto("El usuario y correo ya existen!! <br> Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariomuycortocorreocambiadofotocambiadadatosactualizados':
        mostraravisoconfoto("El nombre de usuario es muy corto <br> Correo, foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariomuycortocorreoyaexistentefotocambiadadatosactualizados':
        mostraravisoconfoto("El nombre de usuario es muy corto y el correo ya existe!! <br> Foto y datos modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
}
?>