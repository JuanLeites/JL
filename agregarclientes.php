<?php 
include("chequeodelogin.php"); 
include("coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["cedula"]) && isset($_POST["fechanac"]) && isset($_POST["contacto"])) {
        if ($_POST["nombre"] != "" && $_POST["cedula"] != "" && $_POST["fechanac"] != "" && $_POST["contacto"] != "") {
            mysqli_query($basededatos, 'INSERT INTO cliente (nombre, cedula, fecha_de_nacimiento, contacto) VALUES ("' . $_POST["nombre"] . '","' . $_POST["cedula"] . '","' . $_POST["fechanac"] . '","' . $_POST["contacto"] . '");');
            echo "<script>alert('Cliete Registrado')</script>";
        }else{
            echo "<script>alert('debe ingresar datos')</script>";
        }
    }else{
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
        <input type="text" placeholder="nombre" name="nombre">

        <input type="number" placeholder="Cedula" name="cedula">

        <p>Fecha de nacimiento:</p>
        <input type="date" name="fechanac">

        <input type="number" placeholder="contacto" name="contacto">
        <input type="submit">
    </form>
</body>

</html>