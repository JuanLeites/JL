<?php 
include_once("../funciones.php");
session_start();
if(isset($_SESSION["acertado"])){
  header("Location:cambiarcontraseña.php");
  die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me olvidé la contraseña</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../imagenes/LUPF.png" type="image/x-icon">

    <script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">
    
</head>
<body class="scroll">
  <form method="post" action="ingresarcodigo.php" class="formularios meolvidelacontraseña">
    <img src="../imagenes/JL.svg" class="logoenformulario">
    <p class="textoformulario">Introduce el correo electrónico o el nombre de usuario asociados a tu cuenta para cambiar tu contraseña.</p>
    <input type="text" placeholder="ingrece email o Usuario" name="destino" required>
    <input type="submit" value="Enviar Código">
 </form>
<a href="../index.php" id="reg">regresar</a>
<?php include_once("footermeolvide.html") ?>
</body>
</html>
<?php

if (isset($_GET['causa'])) {
  switch ($_GET['causa']) {
      case "sindatos":
        mostraralerta("No hay cuentas Con ese Correo o Usuario","","");
        break;;
  }
}

?>
