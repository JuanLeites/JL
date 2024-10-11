<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

$consultausuario = mysqli_query($basededatos, 'SELECT * FROM usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["contraseñavieja"]) && isset($_POST["contraseñanueva"]) && isset($_POST["contraseñanueva2"])) { //si estan seteados los valores
        if ($_POST["contraseñavieja"] != "" && $_POST["contraseñanueva"] != "" && $_POST["contraseñanueva2"] != "") { //si no estan vacios
            if ($_POST["contraseñanueva"] == $_POST["contraseñanueva2"]) {
                $contraseña = $_POST["contraseñavieja"];
                if (password_verify($contraseña, $usuario["Contraseña"])) { // si la contraseña ingresada coincide con la contraseña del usuario
                    if (strlen($_POST["contraseñanueva"]) > 5) { //strlen retorna la cantidad de caracteres

                        mysqli_query($basededatos, 'UPDATE `usuario` SET `contraseña`="' . password_hash($_POST["contraseñanueva2"], PASSWORD_BCRYPT) . '" WHERE Usuario ="' . $_SESSION["usuario"] . '";');
                        $opcion = "contraseñacambiada";
                    } else {
                        $opcion = "contraseñacorta";
                    }
                } else {
                    $opcion = "contraseñaactualincorrecta";
                }
            } else {
                $opcion = "contraseñasnocoinciden";
            }
        } else {
            $opcion = "camposincompletos";
        }
    }
} else {
    $opcion = "";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Contraseña</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  
    ?>
    
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
</head>

<body>
    <form method="POST" class="formularios">

        <label for="contraseñavieja">Ingrese su contraseña Acutal</label>
        <input class="inputpass1" type="password" name="contraseñavieja" id="contraseñavieja">
        <img class="ojo1" id='ver' src="imagenes/ojocerrado.png">

        <hr id="linea">

        <label for="contraseñanueva">Ingrese Contraseña nueva</label>
        <input class="inputpass2" type="password" name="contraseñanueva" id="contraseñanueva">
        <img class="ojo2" id='ver' src="imagenes/ojocerrado.png">

        <label for="contraseñanueva2">Repita Contraseña nueva</label>
        <input class="inputpass3" type="password" name="contraseñanueva2" id="contraseñanueva2">
        <img class="ojo3" id='ver' src="imagenes/ojocerrado.png">
        <input type="submit" value="Cambiar">
    </form>
    <a href="menuprincipal.php" id="reg">regresar</a>
</body>
<script src="js/funciones.js" type="module"></script>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'contraseñacambiada';
        mostraraviso('Contraseña actualizada con éxito', $colorfondo, $colorprincipal);
        break;
    case 'contraseñacorta';
        mostraralerta('La contraseña debe de tener al menos 6 caracteres', $colorfondo, $colorprincipal);
        break;
    case 'contraseñaactualincorrecta';
        mostraralerta('La contraseña que has ingresado no es la correcta', $colorfondo, $colorprincipal);
        break;
    case 'contraseñasnocoinciden';
        mostraralerta('Las contraseñas que has ingresado no coinciden', $colorfondo, $colorprincipal);
        break;
    case 'camposincompletos';
        mostraralerta("Debe de rellenar todos los campos", $colorfondo, $colorprincipal);
        break;
}
?>