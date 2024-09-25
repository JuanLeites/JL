<?php
include("chequeodelogin.php");
include("coneccionBD.php");



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen mensual</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>

    <script src="LIBRERIAS/chart.js/chart.umd.js"></script>

</head>

<body>
    <div class="buscador"><input type="date" min="2024-07-01" value="<?php echo date('Y-m-d'), strtotime('-30 days');  ?>" class="fechadesde"> <input type="date" max="<?php echo date("Y-m-d"); ?>"></div>
    <div class="contenedordegraficas">
        <canvas id="grafica1"></canvas>
        <canvas id="grafica2"></canvas>
        <canvas id="grafica3"></canvas>
        <canvas id="grafica4"></canvas>

    </div>
    <?php include("barralateral.html") ?>
</body>
<script>
var canvas1 = document.getElementById('grafica1').getContext('2d');
var canvas2 = document.getElementById('grafica2').getContext('2d');
var canvas3 = document.getElementById('grafica3').getContext('2d');
var canvas4 = document.getElementById('grafica4').getContext('2d');

function actualizargraficas(){
    canvas1.update();
    canvas2.update();
    canvas3.update();
    canvas4.update();
}

function actualizargrafica1(){
    const cargaDatos = new XMLHttpRequest();
    cargaDatos.open('GET', 'apis/apiresumen.php');
    cargaDatos.send()
    cargaDatos.onload = function () {

    }
}

const data = {
    labels: ['Producto a', 'Producto b', 'Producto c'],
  datasets: [
    {
      label: 'Numero de datos',
      data: [1, 2, 3],
      borderColor: '#36A2EB',
      backgroundColor: [
      'rgba(255, 99, 132, 0.9)',
      'rgba(255, 159, 64, 0.9)',
      'rgba(255, 205, 86, 0.9)',
      'rgba(75, 192, 192, 0.9)',
      'rgba(54, 162, 235, 0.9)',
      'rgba(153, 102, 255, 0.9)',
      'rgba(201, 203, 207, 0.9)'
    ]
    }]
};


new Chart(canvas1, {
    type: 'line',
    data: data,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  new Chart(canvas2, {
    type: 'doughnut',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
  });
  new Chart(canvas3, {
    type: 'bar',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
  });
  new Chart(canvas4, {
    type: 'pie',
  data: data,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
  });

</script>

</html>