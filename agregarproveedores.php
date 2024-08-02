<?php
 include("chequeodelogin.php");
 include("coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["RS"]) && isset($_POST["rut"]) && isset($_POST["contacto"])) {
        if ($_POST["RS"] != "" && $_POST["rut"] != "" && $_POST["contacto"] != "") {
            mysqli_query($basededatos, 'INSERT INTO proveedor (Contacto, Razón_Social,RUT) VALUES ("' . $_POST["contacto"] . '","' . $_POST["RS"] . '","' . $_POST["rut"] . '");');
            echo "<script>alert('Proveedor Registrado')</script>";
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

<body>
    
    <form method="POST" class="conenedordeagregador">
        <h1>Agregar Proveedores</h1>
        <input type="text" placeholder="Razón Social" name="RS" require>
        <input type="number" placeholder="RUT" name="rut" require>
        <input type="text" placeholder="contacto" name="contacto" require>
        <input type="submit">
    </form>
    
    <?php include("barralateral.html") ?>
</body>

</html>