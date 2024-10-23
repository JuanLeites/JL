<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
if (isset($_GET["id"])) {
    $datosdelsorteo = mysqli_fetch_array(mysqli_query($basededatos, 'SELECT * FROM Sorteo WHERE ID_SORTEO="' . $_GET["id"] . '"'));
    $ganadores = mysqli_query($basededatos, 'SELECT Nombre,Cédula FROM Sorteo s, Ganador g, Cliente c WHERE s.ID_SORTEO=g.ID_SORTEO and g.ID_CLIENTE=c.ID_CLIENTE and  s.ID_SORTEO="' . $_GET["id"] . '"');
} else {
    header("Location:sorteos.php?causa?idnoseteada");
    die();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver datos del sorteo</title>

    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); ?>

    <link rel="shortcut icon" href="imagenes/icons/sorteo.png" type="image/x-icon">
</head>

<body>

    <div class="formularios">
        <h1>Datos del Sorteo</h1>
        <p>Premio : <?php echo $datosdelsorteo["Premio"]; ?> </p>
        <p>Cantidad de ganadores : <?php echo $datosdelsorteo["Cantidad"]; ?> </p>
        <p>Fecha de realización : <?php echo $datosdelsorteo["Fecha_realización"]; ?></p>
        <div class="contenedordeganadores">


            <?php
            foreach ($ganadores as $cadaganador) {
                echo "<p class='ganadores'>" . $cadaganador["Nombre"] . " - " . $cadaganador["Cédula"] . "</p>";
            }

            ?>
        </div>
    </div>

    <?php include_once("barralateral.html");
    ?>
</body>
<script type="module">

</script>

</html>