<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Clientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("barralateral.html") ?>
    <form method="POST" class="conenedordeagregador">
        <h1>Agregar Proveedores</h1>
        <input type="text" placeholder="Razón Social" name="RS" require>
        <input type="number" placeholder="RUT" name="rut" require>
        <input type="number" placeholder="telefono" require>
        <input type="submit">
    </form>
</body>

</html>