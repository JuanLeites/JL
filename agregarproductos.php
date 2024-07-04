<?php include("chequeodelogin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agregar productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("barralateral.html") ?>
    <form method="POST" class="conenedordeagregador">
        <h1>Agregar un Producto</h1>
        <input type="text" placeholder="Nombre" name="nombre">
        <input type="number" placeholder="codigo de barras" name="codbarras">
        <input type="text" placeholder="descripcion" name="descripcion">
        <input type="text" placeholder="marca" name="marca">
        <input type="number" placeholder="cantidad">
        <input type="text" placeholder="categoria">
        <input type="text" placeholder="iva">
        <input type="submit">
    </form>
</body>

</html>