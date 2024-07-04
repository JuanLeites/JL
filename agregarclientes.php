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
        <h1>Agregar Clientes</h1>
        <input type="number" placeholder="Cedula" name="cedula">
        <input type="text" placeholder="nombre" name="nombre">
        <input type="number" placeholder="deuda" name="deuda" value="0">
        <p>Fecha de nacimiento:</p>
        <input type="date">
        <input type="number" placeholder="tickets del sorteo" value="0">
        <input type="number" placeholder="contacto">
        <input type="submit">
    </form>
</body>

</html>