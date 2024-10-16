<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");



?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resumen mensual</title>
  <link rel="stylesheet" href="css/style.css">
  <?php include_once("css/colorespersonalizados.php"); ?>

  <link rel="shortcut icon" href="imagenes/icons/grafica.png" type="image/x-icon">


  <script src="LIBRERIAS/chart.js/chart.umd.js"></script>

</head>

<body>
  <div class="buscador">
    <input type="date" min="2024-07-01" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>" class="fechainicio">
    <input type="date" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>" class="fechafinal">
  </div>
  <div class="contenedordegraficas">
    <canvas id="grafica1"></canvas>
    <canvas id="grafica2"></canvas>
    <canvas id="grafica3"></canvas>
    <canvas id="grafica4"></canvas>
  </div>
  <?php include_once("barralateral.html") ?>
</body>
<script src="js/scriptgraficas.js"></script>

</html>