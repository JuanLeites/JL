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
    <div class="con">
        <div class="sub">
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
        var etiquetasIniciales = <?php echo $etiquetasJson; ?>;
        var datosIniciales = <?php echo $datosJson; ?>;
    </script>
    <script src="js/PieChart.js"></script>
    <script src="js/LineChart.js"></script>
</body>
</html>
