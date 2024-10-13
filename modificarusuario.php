<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

//en todos los casos posbiles guardamos lo que pasa en la variable "$opcion" para luego mostrar un mensaje despues que se carga el html
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION["usuario"] != $_POST["usuario"]) { //si el nombre de usuario ingresados y el usuario actual son distintos
        if ($_SESSION["correo"] != $_POST["correo"]) {//si el correo ingresado es distinto al del usuario (se modificó)
            $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";'); //consulta para ver si está registrado el nuevo nombre de usuario
            $checkcorreo =mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE  correo ="'.$_POST["correo"].'";');
            if (mysqli_num_rows($checkuser) == 0) { // si no hay ningun usuario con ese mismo nombre de usuario o ese corro
                if (mysqli_num_rows($checkcorreo) == 0) {//si no hay un correo así en la BD
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
                        $_SESSION["correo"]=$_POST["correo"];
                        $opcion = "usuariocorreoyfotocambiados";
                    } else { // si no se subió una foto pero si se cambió el usuario y el correo
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] .  '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["usuario"] = $_POST["usuario"];
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $_SESSION["correo"]=$_POST["correo"];
                        $opcion = "usuariocorreocambiado";
                    }
                }else{ // si ya hay un correo registrado igual al que el usuario ingresó pero el usuario no está en la BD, entra acá
                    if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
                        @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                        if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
                            $_SESSION["fotoperf"] = $_POST["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        } else { //si la foto no existe
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                            $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        }
                        $_SESSION["usuario"] = $_POST["usuario"]; //guardamos los nuevos datos en las variables 
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $opcion = "usuarioyfotocambiadoscorreoyaexistente";
                    } else { // si no se subió una foto pero si se cambió el usuario y el correo
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["usuario"] = $_POST["usuario"];
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $opcion = "usuariocambiadocorreoyaexistente";
                    }
                }
            } else { // si llegase a haber un usuario con ese mismo usuario ingresado 
                if (mysqli_num_rows($checkcorreo) == 0) {//chequeamos el correo
                    if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
                        @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                        if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] .  '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
                            $_SESSION["fotoperf"] = $_POST["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        } else { //si la foto no existe
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '",`Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                            $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        }
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $_SESSION["correo"]=$_POST["correo"];
                        $opcion = "correoyfotocambiadosusuarioyaexistente";
                    } else { // si no se subió una foto pero si se cambió el usuario y el correo
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET  `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] .  '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $_SESSION["correo"]=$_POST["correo"];
                        $opcion = "correocambiadousuarioyaexistente";
                    }
                }else{ // si ya hay un correo registrado igual al que el usuario ingresó pero el usuario no está en la BD, entra acá
                    if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
                        @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                        if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
                            $_SESSION["fotoperf"] = $_POST["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        } else { //si la foto no existe
                            move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
                            mysqli_query($basededatos, 'UPDATE `Usuario` SET  `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                            $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                        }
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $opcion = "datosyfotocambiadoscorreoyaexistenteyusuariotambien";
                        } else { // si no se subió una foto pero si se cambió el usuario y el correo
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET  `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["nombre"] = $_POST["nombre"];
                        $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                        $opcion = "datoscambiadocorreoyaexistenteyusuariotambien";
                    }
                }
            }
        } else { // si no se camió el correo, pero si se cambió el usuario
            $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario ="' . $_POST["usuario"] . '";'); //consulta para ver si está registrado el nuevo nombre de usuario
            if (mysqli_num_rows($checkuser) == 0) { // si no hay ningun usuario con ese mismo nombre de usuario
                if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { //si se llegase a cargar una foto
                    @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                    if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { //si la foto de perfil ya existe(el nombre), la carga con el nombre de usuario también
                        move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_POST["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva foto con el usuario concatenado
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_POST["usuario"] . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto y le agregamos el nuevo usuario al nombre de la foto pq ya hay una foto con el mismo nombre.
                        $_SESSION["fotoperf"] = $_POST["usuario"] . $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                    } else { //si la foto no existe
                        move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la foto con el nombre q ya tenia 
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";'); //actualizamos en la tabla usuario el usuario que está, iniciado incluyendo la foto.
                        $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name']; //guarda la foto depende como la haya guardado en la base de datos
                    }
                    $_SESSION["usuario"] = $_POST["usuario"]; //guardamos los nuevos datos en las variables 
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    $opcion = "usuarioyfotocambiados";
                } else { // si no se subió una foto pero si se cambió el usuario
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Usuario` = "' . $_POST["usuario"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
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
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name'];
                    } else { //y si no existe, la carga normal
                        move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                    }
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    $opcion = "datosyfotocambiadosusuarioyaregistrado";
                } else {
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    $opcion = "datosactualizadosusuarioyaregistrado";
                }
            }
        }
    } else { // si no se cambia el nombre de usuario
        if($_SESSION["correo"] != $_POST["correo"]){ // chequear si se cambió el correo
            $checkuser = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE correo ="' . $_POST["correo"] . '";');
            if (mysqli_num_rows($checkuser) == 0) {// si no hay usuarios con ese correo
                if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != ""){//si se cargó foto
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
                    $_SESSION["correo"]=$_POST["correo"];
                    $opcion = "datosycorreoyfotoactualizada";
                }else{//si no se cargó foto
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '", `Correo` = "' . $_POST["correo"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    $_SESSION["correo"]=$_POST["correo"];
                    $opcion = "datosactualizadosycorreo";
                }
                //actualizar datos con correo incluido
            }else{//hay un usuario con ese correo
                if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != ""){//si se cargó foto
                    @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                    if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { // si ya existe una foto con el mismo nombre foto
                        move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta con el nombre de usuario
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name'];
                    } else {
                        move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                        mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                    }
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    
                    $opcion = "datosyfotoactualizadacorreoyausado";
                }else{//si no se cargó foto
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["nombre"] = $_POST["nombre"];
                    $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                    $opcion = "datosactualizadoscorroyausado";
                }
                //cambiar todos los datos, menos correo y usuario
            }

        }else{//si no se cambia el correo ni el usuario
            if (isset($_FILES["fotoperfil"]["tmp_name"]) && $_FILES["fotoperfil"]["name"] != "") { // si se cargó una foto
                @unlink("fotoperfil/" . $_SESSION["fotoperf"]); //borra la foto de perfil anterior
                if (file_exists('fotoperfil/' . $_FILES['fotoperfil']['name'])) { // si ya existe una foto con el mismo nombre foto
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta con el nombre de usuario
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_SESSION["usuario"] . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["fotoperf"] = $_SESSION["usuario"] . $_FILES['fotoperfil']['name'];
                } else {
                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $_FILES['fotoperfil']['name']); //carga la nueva en la carpeta
                    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '",`Foto_Perfil` = "' . $_FILES['fotoperfil']['name'] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                    $_SESSION["fotoperf"] = $_FILES['fotoperfil']['name'];
                }
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "datosyfotoactualizada";
            } else {
    
                mysqli_query($basededatos, 'UPDATE `Usuario` SET `Nombre` = "' . $_POST["nombre"] . '", `Fecha_Nacimiento` = "' . $_POST["fechanac"] . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                $_SESSION["nombre"] = $_POST["nombre"];
                $_SESSION["fecha_nacimiento"] = $_POST["fechanac"];
                $opcion = "datosactualizados";
            }
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
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
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
    case'usuariocorreoyfotocambiados':
        mostraravisoconfoto("Usuario, correo , datos y foto modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariocorreocambiado':
        mostraraviso("Usuario, correo y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuarioyfotocambiadoscorreoyaexistente':
        mostraravisoconfoto("El correo ya está en uso. <br> Usuario, datos y foto modificados con éxito, ", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariocambiadocorreoyaexistente':
        mostraraviso("El correo ya está en uso. <br> Usuario y datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'correoyfotocambiadosusuarioyaexistente':
        mostraravisoconfoto("El usuario ya está en uso.<br> Correo, datos y Foto modificados con éxito",$colorfondo,$colorprincipal,"fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'correocambiadousuarioyaexistente':
        mostraraviso("El Usuario ya está en uso.<br>Correo y datos cambiados con éxito", $colorfondo, $colorprincipal);
    break;
    case 'datosyfotocambiadoscorreoyaexistenteyusuariotambien':
        mostraravisoconfoto("El Usuario y el correo ya están en uso.<br>Datos y foto modificados con éxito", $colorfondo, $colorprincipal,"fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datoscambiadocorreoyaexistenteyusuariotambien':
        mostraraviso("El Usuario y el correo ya están en uso.<br>Datos cambiados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'usuarioyfotocambiados';
        mostraravisoconfoto("Usuario y datos actualizados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'usuariocambiado';
        mostraraviso('Usuario y datos modificados con éxito', $colorfondo, $colorprincipal);
        break;
    case 'datosyfotocambiadosusuarioyaregistrado';
        mostraravisoconfoto("El Usuario ya está en uso.<br> Datos y foto modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizadosusuarioyaregistrado';
        mostraraviso("El Usuario ya está en uso.<br> Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosyfotoactualizada';
        mostraravisoconfoto("Datos y foto modificados con éxito", $colorfondo, $colorprincipal, "fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizados';
        mostraraviso("Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosycorreoyfotoactualizada':
        mostraravisoconfoto("Correo, datos y Foto modificados con éxito",$colorfondo,$colorprincipal,"fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'correoyfotocambiadosusuarioyaexistente':
        mostraravisoconfoto("El usuario ya está en uso.<br> Correo, datos y Foto modificados con éxito",$colorfondo,$colorprincipal,"fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizadosycorreo':
        mostraraviso("Datos y correo modificados con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosyfotoactualizadacorreoyausado':
        mostraravisoconfoto("El Correo ya está en uso.<br>Datos y Foto modificados con éxito",$colorfondo,$colorprincipal,"fotoperfil/" . $_SESSION["fotoperf"]);
        break;
    case 'datosactualizadoscorroyausado':
        mostraraviso("El Correo ya está en uso.<br>Datos modificados con éxito", $colorfondo, $colorprincipal);
        break;




}
?>