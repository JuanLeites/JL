<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos,'UPDATE `proveedor` SET `Contacto` = "'.$_POST["contacto"].'", `Razón_Social` = "'.$_POST["RS"].'", `RUT` = "'.$_POST["rut"].'" WHERE `proveedor`.`ID_PROVEEDOR` =' . $_GET["id"]);
    echo "<script>alert('Proveedor actualizado')</script>";
}

if (isset($_GET["id"])) {
    $consultaproveedor = mysqli_query($basededatos, 'SELECT * FROM proveedor WHERE ID_PROVEEDOR=' . $_GET["id"]);
    $proveedor = mysqli_fetch_assoc($consultaproveedor);
} else {
    header("Location:proveedores.php");
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Modificar Proveedor</h1>
        <label for="RS">Razón Social</label>
        <input type="text" placeholder="Razón Social" name="RS" id="RS" value="<?php echo $proveedor['Razón_Social']; ?>">

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" name="rut" id="rut" value="<?php echo $proveedor['RUT']; ?>">

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" value="<?php echo $proveedor['Contacto']; ?>">

        <input type="submit" value="Actualizar">

    </form>
    <a href="../proveedores.php" id="reg">regresar</a>
</body>

</html>