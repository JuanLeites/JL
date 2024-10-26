<?php 
include_once("../coneccionBD.php");
include_once("../funciones.php");
session_start();

if(isset($_SESSION["intentosdereestablecimiento"])){
    if($_SESSION["intentosdereestablecimiento"]==0){
        header("Location:../index.php?causa=intentosagotados");
        die();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["destino"])){ // destino puede ser el usuario o correo.

        //hacemos dos consultas una por si fuese el correo y otra por si fuese el usuario:
        $consultaconcorreo=mysqli_query($basededatos,'SELECT Nombre, Correo, Usuario FROM Usuario WHERE Correo="'.$_POST['destino'].'";');
        $consultaconusuario=mysqli_query($basededatos,'SELECT Nombre, Correo, Usuario FROM Usuario WHERE Usuario="'.$_POST['destino'].'";');
        
        if(mysqli_num_rows($consultaconusuario)==1){// si la cantidad es uno, significa que si hay un usuario con ese usuario ingresado
            $_SESSION["arraydeusuario"] = mysqli_fetch_assoc($consultaconusuario); // obteneemos en una variable de sesion el array asociativo con el usuario
            //echo "el correo del usuario es: ".$usuario["Correo"];
            $_SESSION["codigo"] = generarcodigo(6);
            enviarcodigoparareestablecer($_SESSION["arraydeusuario"]["Nombre"], $_SESSION["codigo"],$_SESSION["arraydeusuario"]["Correo"]); // llamamos a la funciión que envía un mail con el código.
            $_SESSION["intentosdereestablecimiento"]=5;
        }else{//si no hay un usuario con el dato que pasó por el input
            if(mysqli_num_rows($consultaconcorreo)==1){//si llega a haber un usuario con ese correo registrado
                $_SESSION["arraydeusuario"] = mysqli_fetch_assoc($consultaconcorreo);
                $_SESSION["codigo"] = generarcodigo(6);
                enviarcodigoparareestablecer($_SESSION["arraydeusuario"]["Nombre"], $_SESSION["codigo"],$_SESSION["arraydeusuario"]["Correo"]);// lo mismo que arriba
                $_SESSION["intentosdereestablecimiento"]=5;
            }else{
                header("Location:meolvide.php?causa=sindatos");
                die();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reestablecer contraseña</title>
    <link rel="stylesheet" href="../css/style.css">

    <script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">
    
</head>
<body>
    <form method="post" action="cambiarcontraseña.php" class="formularios meolvidelacontraseña">
        <img src="../imagenes/JL.svg" class="logoenformulario">
        <p class="textoformulario">Introduce el código de 6 digitos que ha llegado a tu correo.</p>
        <input type="text" placeholder="XXXXXX" id="codigo" inputmode="numeric" pattern="[0-9]{6}" min="000000" max="999999" name="codigoingresado" minlength="6" maxlength="6" required title="*Debes ingresar unicamente 6 caracteres numericos">

        

        <?php if(isset($_GET["causa"])){
            if($_GET["causa"]=="codigoincorrecto"){
                mostraralerta("Código incorrecto!! <br>".$_SESSION["intentosdereestablecimiento"]." Intentos Restantes","","");
            }
        } ?>
        <input type="submit" value="Verificar código">
    </form>

    <a href="../index.php" id="reg">regresar</a>
    <?php include_once("footermeolvide.html") ?>
</body>
</html>