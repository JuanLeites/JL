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

function obtenerDatosProductosVendidos($basededatos, $fechaInicio, $fechaFinal) {
    $consulta = "SELECT p.Nombre as Nombre, SUM(pv.Cantidad_de_Venta) as Total 
                 FROM Productos_Vendidos pv 
                 JOIN Producto p ON pv.ID_PRODUCTO = p.ID_PRODUCTO 
                 JOIN Venta v ON pv.ID_VENTA = v.ID_VENTA 
                 WHERE v.Fecha_Venta BETWEEN ? AND ? 
                 GROUP BY p.ID_PRODUCTO 
                 ORDER BY Total ASC 
                 LIMIT 5";

    $stmt = $basededatos->prepare($consulta);
    $stmt->bind_param("ss", $fechaInicio, $fechaFinal);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $nombres = [];
    $totales = [];

    while ($fila = $resultado->fetch_assoc()) {
        $nombres[] = $fila['Nombre'];
        $totales[] = $fila['Total'];
    }

    return ['nombres' => $nombres, 'totales' => $totales];
}

$fechaInicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-d', strtotime('-30 days'));
$fechaFinal = isset($_GET['fecha_final']) ? $_GET['fecha_final'] : date('Y-m-d');

if (isset($_GET['ajax'])) {
    if ($_GET['tipo'] == 'ventas') {
        echo json_encode(obtenerDatosVentas($basededatos, $fechaInicio, $fechaFinal));
    } elseif ($_GET['tipo'] == 'productos') {
        echo json_encode(obtenerDatosProductosVendidos($basededatos, $fechaInicio, $fechaFinal));
    }
    exit;
}

$datosInicialesVentas = obtenerDatosVentas($basededatos, $fechaInicio, $fechaFinal);
$datosInicialesProductos = obtenerDatosProductosVendidos($basededatos, $fechaInicio, $fechaFinal);

$etiquetasVentasJson = json_encode($datosInicialesVentas['etiquetas']);
$datosVentasJson = json_encode($datosInicialesVentas['datos']);
$nombresProductosJson = json_encode($datosInicialesProductos['nombres']);
$totalesProductosJson = json_encode($datosInicialesProductos['totales']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Mensual</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>
    <script src="LIBRERIAS/chart.js/chart.umd.js"></script>
</head>
<body>
<div class="con">
    <div class="sub">
        <h1>Productos más vendidos</h1>
        <canvas id="PieChart"></canvas>
    </div>
    <div class="sub">
        <canvas id="LineChart"></canvas>
        
        <div class="fecha">
            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fechaInicio; ?>">

            <label for="fecha_final">Fecha de fin:</label>
            <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $fechaFinal; ?>">
        </div>
    </div>
</div>

    <?php include("barraLateral.html") ?>
    
    <script>
        var etiquetasVentasIniciales = <?php echo $etiquetasVentasJson; ?>;
        var datosVentasIniciales = <?php echo $datosVentasJson; ?>;
        var nombresProductosIniciales = <?php echo $nombresProductosJson; ?>;
        var totalesProductosIniciales = <?php echo $totalesProductosJson; ?>;
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx2 = document.getElementById('PieChart').getContext('2d');
        var PieChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: nombresProductosIniciales,
                datasets: [{
                    label: 'Productos Vendidos',
                    data: totalesProductosIniciales,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        function actualizarGraficaPie() {
            var fechaInicio = document.getElementById('fecha_inicio').value;
            var fechaFinal = document.getElementById('fecha_final').value;

            fetch(`?ajax=1&tipo=productos&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`)
                .then(response => response.json())
                .then(data => {
                    PieChart.data.labels = data.nombres;
                    PieChart.data.datasets[0].data = data.totales;
                    PieChart.update();
                });
        }

        setInterval(actualizarGraficaPie, 5000);
        document.getElementById('fecha_inicio').addEventListener('change', actualizarGraficaPie);
        document.getElementById('fecha_final').addEventListener('change', actualizarGraficaPie);
    });

    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('LineChart').getContext('2d');
        var LineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: etiquetasVentasIniciales,
                datasets: [{
                    label: 'Número de ventas',
                    data: datosVentasIniciales,
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

        function actualizarGraficaLine() {
            var fechaInicio = document.getElementById('fecha_inicio').value;
            var fechaFinal = document.getElementById('fecha_final').value;

            fetch(`?ajax=1&tipo=ventas&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`)
                .then(response => response.json())
                .then(data => {
                    LineChart.data.labels = data.etiquetas;
                    LineChart.data.datasets[0].data = data.datos;
                    LineChart.update();
                });
        }

        setInterval(actualizarGraficaLine, 5000);
        document.getElementById('fecha_inicio').addEventListener('change', actualizarGraficaLine);
        document.getElementById('fecha_final').addEventListener('change', actualizarGraficaLine);
    });
    </script>
</body>
</html>
