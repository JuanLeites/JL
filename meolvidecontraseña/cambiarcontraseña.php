<?php 
include_once("../coneccionBD.php");
include_once("../funciones.php");
session_start();
$intentos = 5;

if(!isset($_SESSION["acertado"])){//si no está acertado el codigo todavia si ya se seteo esto no se hace
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if( $_POST["codigoingresado"]!=$_SESSION["codigo"] ){//si son distintos
            if(!isset($_SESSION["intentosdereestablecimiento"])){
                $_SESSION["intentosdereestablecimiento"]=$intentos;
            }else{
                $_SESSION["intentosdereestablecimiento"]--;
            }
            header("Location:ingresarcodigo.php?causa=codigoincorrecto");//redirigimos a ingresarcodigo.php con una causa y pasamos el usuario por get ya que necesitamos el usuario
            die();
        }else{
            $_SESSION["acertado"]=TRUE; // seteamos una variablepara saber que el codigo fue seteado
        }
    }
}

if(!isset($_SESSION["codigo"])){
    header("Location:../index.php?causa=nohagastrampa");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizala!</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include_once("../css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">

    <script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">
    <script src="../js/funciones.js" type="module"></script>
    
</head>
<body>
    <form class="formularios" method="post" action="actualizadordecontraseña.php">
    <img src="../imagenes/JL.svg" class="logoenformulario">
        <h2>Bienvenido, <?php echo $_SESSION["arraydeusuario"]["Nombre"]; echo "<input type='hidden' name='usuario' value='".$_SESSION["arraydeusuario"]["Usuario"]."'>" ?> </h2>
        <label for="contraseñameolvide">Ingrese una nueva contraseña:</label>
        <input id="contraseñameolvide" type="password" minlength="6" name="pass1"><img class="ojo1meolvide" id='ver' src="../imagenes/ojocerrado.png">

        <label for="contraseñameolvide2">Repita la nueva contraseña:</label>
        <input id="contraseñameolvide2" type="password" minlength="6" name="pass2"><img class="ojo2meolvide" id='ver' src="../imagenes/ojocerrado.png">



        <input type="submit" value="Actualizar">
    </form>
    <a href="../index.php" id="reg">regresar</a>
    <?php include_once("footermeolvide.html") ?>
</body>
</html>
<?php 
if(isset($_GET["causa"])){
    switch($_GET["causa"]){
        case "contraseñascortas":
            mostraralerta("Ambas contraseñas deben de tener más de 6 caracteres!","","");
            break;;
        case "contraseñasdistintas":
            mostraralerta("Las contraseñas deben de ser iguales!","","");

    }

        
}
?>