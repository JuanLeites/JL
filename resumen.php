<?php
include("chequeodelogin.php");
include("coneccionBD.php");

function obtenerDatosVentas($basededatos, $fechaInicio, $fechaFinal) {
    $consulta = "SELECT DATE(Fecha_Venta) as Fecha, COUNT(*) as Total FROM Venta WHERE Fecha_Venta BETWEEN ? AND ? GROUP BY DATE(Fecha_Venta) ORDER BY Fecha_Venta";

    $stmt = $basededatos->prepare($consulta);
    $stmt->bind_param("ss", $fechaInicio, $fechaFinal);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $etiquetas = [];
    $datos = [];

    while ($fila = $resultado->fetch_assoc()) {
        $etiquetas[] = $fila['Fecha'];
        $datos[] = $fila['Total'];
    }

    return ['etiquetas' => $etiquetas, 'datos' => $datos];
}

$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d', strtotime('-30 days'));
$fechaFinal = isset($_GET['fecha_final']) ? $_GET['fecha_final'] : date('Y-m-d');

if (isset($_GET['ajax'])) {
    echo json_encode(obtenerDatosVentas($basededatos, $fechaInicio, $fechaFinal));
    exit;
}

$datosIniciales = obtenerDatosVentas($basededatos, $fechaInicio, $fechaFinal);
$etiquetasJson = json_encode($datosIniciales['etiquetas']);
$datosJson = json_encode($datosIniciales['datos']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Mensual</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="LIBRERIAS/chart.js/chart.umd.js"></script>
</head>
<body>
    <div class="contenedor">
        <canvas id="graficoVentas"></canvas>
        <form id="formularioFechas">
            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">

            <label for="fecha_final">Fecha de fin:</label>
            <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $fechaFinal; ?>">
        </form>
    </div>

    <?php include("barraLateral.html") ?>

    <script>
    var ctx = document.getElementById('graficoVentas').getContext('2d');
    var graficoVentas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $etiquetasJson; ?>,
            datasets: [{
                label: 'Número de ventas',
                data: <?php echo $datosJson; ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    function actualizarGrafico() {
        var fechaInicio = document.getElementById('fecha_inicio').value;
        var fechaFinal = document.getElementById('fecha_final').value;
        
        fetch(`?ajax=1&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`)
            .then(response => response.json())
            .then(data => {
                graficoVentas.data.labels = data.etiquetas;
                graficoVentas.data.datasets[0].data = data.datos;
                graficoVentas.update();
            });
    }

    setInterval(actualizarGrafico, 5000);
    document.getElementById('fecha_inicio').addEventListener('change', actualizarGrafico);
    document.getElementById('fecha_final').addEventListener('change', actualizarGrafico);
    </script>
</body>
</html>
