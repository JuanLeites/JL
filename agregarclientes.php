<?php
include("chequeodelogin.php");
include("coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["cedula"]) && isset($_POST["fechanac"]) && isset($_POST["contacto"])) {
        if ($_POST["nombre"] != "" && $_POST["cedula"] != "" && $_POST["fechanac"] != "" && $_POST["contacto"] != "") {
            mysqli_query($basededatos, 'INSERT INTO cliente (Cédula, Nombre, Fecha_de_Nacimiento, Contacto,RUT) VALUES ("' . $_POST["cedula"] . '","' . $_POST["nombre"] . '","' . $_POST["fechanac"] . '","' . $_POST["contacto"] . '","' . $_POST["rut"] . '");');
            echo "<script>alert('Cliete Registrado')</script>";
        } else {
            echo "<script>alert('debe ingresar datos')</script>";
        }
    } else {
        echo "<script>alert('los datos no fueron seteados')</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Clientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<link rel="stylesheet" href="estilomeolvide.css">

<body>
    <?php include("barralateral.html") ?>
    <form method="POST" class="conenedordeagregador">
        <h1>Agregar Clientes</h1>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="nombre" name="nombre" id="nombre">

        <label for="cedula">Cédula</label>
        <input type="number" placeholder="Cedula" name="cedula" id="cedula" min="1000000" max="99999999">

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac"  max="2019-12-31" min="1940-12-31">

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto">

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" name="rut" id="rut">

        <input type="submit" value="agregar">

    </form>
</body>

</html>