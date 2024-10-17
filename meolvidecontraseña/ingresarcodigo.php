<?php 
include_once("../coneccionBD.php");
include_once("../funciones.php");
session_start();
//619546
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["destino"])){
        //hacemos dos consultas una por si fuese el correo y otra por si fuese el usuario:
        $consultaconcorreo=mysqli_query($basededatos,'SELECT * FROM Usuario WHERE Correo="'.$_POST['destino'].'";');
        $consultaconusuario=mysqli_query($basededatos,'SELECT Nombre, Correo, Usuario FROM Usuario WHERE Usuario="'.$_POST['destino'].'";');
        
        if(mysqli_num_rows($consultaconusuario)==1){// si la cantidad es uno, significa que hay un usuario con ese correo
            $_SESSION["arraydeusuario"] = mysqli_fetch_assoc($consultaconusuario);
            //echo "el correo del usuario es: ".$usuario["Correo"];
            $_SESSION["codigo"] = generarcodigo(6);
            enviarcodigoparareestablecer($_SESSION["arraydeusuario"]["Nombre"], $_SESSION["codigo"],$_SESSION["arraydeusuario"]["Correo"]);
            
        }else{//si no hay un usuario con el dato que pasó por el input
            if(mysqli_num_rows($consultaconcorreo)==1){//si llega a haber un correo con el dato que paso por el input
                $_SESSION["arraydeusuario"] = mysqli_fetch_assoc($consultaconcorreo);
                $_SESSION["codigo"] = generarcodigo(6);
                enviarcodigoparareestablecer($_SESSION["arraydeusuario"]["Nombre"], $_SESSION["codigo"],$_SESSION["arraydeusuario"]["Correo"]);
            }else{//si no se ingresó ni un correo ni un nombre de usuario
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
        <input placeholder="Ingrese Código" id="codigo" type="number" min="000000" max="999999" name="codigoingresado" required>
        <?php if(isset($_GET["causa"])){
            if($_GET["causa"]=="codigoincorrecto"){
                mostraralerta("Código incorrecto!!","","");
            }
        } ?>
        <input type="submit" value="Verificar código">
    </form>

    <a href="../index.php" id="reg">regresar</a>
    
</body>
</html>