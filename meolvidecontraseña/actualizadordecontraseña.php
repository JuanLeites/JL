<?php
include_once("../coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"])) {
    session_start();
    if(!isset($_SESSION["acertado"])){//si no acertó lo manda a el index con un error
        header("Location:../index.php?causa=nohagastrampa");
        die();
      }
    if(strlen($_POST["pass1"])<6 || strlen($_POST["pass2"])<6){
        header("Location:cambiarcontraseña.php?causa=contraseñascortas&user=".$_POST["usuario"]);
        die();
    }
    if ($_POST["pass1"] == $_POST["pass2"]) { 
        mysqli_query($basededatos,'UPDATE `usuario` SET `Contraseña` = "'.password_hash($_POST["pass1"], PASSWORD_BCRYPT).'" WHERE Usuario="'.$_POST["usuario"].'"');//actualizamos la contraseña
        session_destroy();
        header("Location:../index.php?causa=contraseñaactualizada");
    }else{
        header("Location:cambiarcontraseña.php?causa=contraseñasdistintas&user=".$_POST["usuario"]);
        die();
    }
} else {
    header("Location:../index.php?causa=err");
}
