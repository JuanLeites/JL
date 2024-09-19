<?php

include("../chequeodelogin.php");
include("../coneccionBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `Usuario` SET `Precio_por_Tickets` = "' . $_POST["precioxtiket"] . '", `Color_Principal` = "' . $_POST["colorprincipal"] . '", `Color_Secundario` = "' . $_POST["colorsecu"] . '", `Color_Fondo` = "' . $_POST["colorfon"] . '";');
    echo "<script>alert('Configuración Actualizada')</script>";
}

$consultausuario = mysqli_query($basededatos, 'SELECT * FROM usuario WHERE Usuario ="' . $_SESSION["usuario"] . '";');
$usuario = mysqli_fetch_assoc($consultausuario);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar configuración</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../imagenes/LUPF.svg" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">

        <label for="precioxtiket">Precio para Generación de Tickets</label>
        <input type="number" step="0.10" min="1" max="10000" name="precioxtiket" id="precioxtiket" value="<?php echo $usuario["Precio_por_Tickets"] ?>">

        <label for="colorprincipal">Color Principal</label>
        <input type="color" name="colorprincipal" id="colorprincipal" value="<?php echo $usuario["Color_Principal"] ?>">

        <label for="colorsecu">Color Secundario</label>
        <input type="color" name="colorsecu" id="colorsecu" value="<?php echo $usuario["Color_Secundario"] ?>">

        <label for="colorfond">Color Fondo</label>
        <input type="color" name="colorfon" id="colorfon" value="<?php echo $usuario["Color_Fondo"] ?>">
        <input type="submit" value="Actualizar">
    </form>
    <a href="../menuprincipal.php" id="reg">regresar</a>
</body>

</html>