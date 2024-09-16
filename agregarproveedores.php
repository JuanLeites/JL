<?php
include("chequeodelogin.php");
include("coneccionBD.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["RS"]) && isset($_POST["rut"]) && isset($_POST["contacto"])) {
        if ($_POST["RS"] != "" && $_POST["rut"] != "" && $_POST["contacto"] != "") {
            mysqli_query($basededatos, 'INSERT INTO proveedor (Contacto, Razón_Social,RUT) VALUES ("' . $_POST["contacto"] . '","' . $_POST["RS"] . '","' . $_POST["rut"] . '");');
            echo "<script>alert('Proveedor Registrado')</script>";
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
    <title>Agregar Proveedore</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagenes/icons/modproveedores.png" type="image/x-icon">
</head>

<body>

    <form method="POST" class="conenedordeagregador">
        <h1>Agregar Proveedor</h1>
        <label for="RS">Razón Social</label>
        <input type="text" placeholder="Razón Social" name="RS" id="RS" required>

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" min="1000000" max="999999999999" name="rut" id="rut" required>

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" required>

        <input type="submit" value="agregar">

    </form>

    <?php include("barralateral.html") ?>
</body>

</html>