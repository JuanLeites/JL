<?php
include("chequeodelogin.php");
include("coneccionBD.php");
$ventas =  mysqli_query($basededatos, 'SELECT * FROM venta ');
$clientes = mysqli_query($basededatos, 'SELECT * FROM cliente ');
$sorteos = mysqli_query($basededatos, 'SELECT * FROM sorteo ');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST["premio"]) && isset($_POST["cantidad"])) {
    if ($_POST["premio"] != "" && isset($_POST["cantidad"])) {
        mysqli_query($basededatos, 'INSERT INTO sorteo (Premio, Cantidad, Fecha_realización) VALUES ("' . $_POST["premio"] . '", "' . $_POST["cantidad"] . '", CURDATE())');
        echo "<script>alert('Sorteo creado')</script>";
    } 
}
 } else {
            echo "<script>alert('debe ingresar datos')</script>";
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un sorteo</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <form method="POST" class="conenedordeagregador" enctype="multipart/form-data">
        <h1>Crear un Sorteo</h1>
            <div class="subcontenedores">
                <label for="premio">Premio</label>
                <input type="text" placeholder="Premio" name="premio" id="premio">

                <label for="cantidad">Cantidad</label>
                <input type="number" placeholder="Cantidad" name="cantidad" id="cantidad">
        <input type="submit">
    </form>
    </div>
    <?php include("barralateral.html") ?>
</body>

</html>