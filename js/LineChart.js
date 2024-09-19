// js/LineChart.js

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('LineChart').getContext('2d');
    var LineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: etiquetasIniciales,
            datasets: [{
                label: 'Número de ventas',
                data: datosIniciales,
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

    // Actualización automática del gráfico
    function actualizarGrafico() {
        var fechaInicio = document.getElementById('fecha_inicio').value;
        var fechaFinal = document.getElementById('fecha_final').value;

        fetch(`?ajax=1&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`)
            .then(response => response.json())
            .then(data => {
                LineChart.data.labels = data.etiquetas;
                LineChart.data.datasets[0].data = data.datos;
                LineChart.update();
            });
    }

    setInterval(actualizarGrafico, 5000);
    document.getElementById('fecha_inicio').addEventListener('change', actualizarGrafico);
    document.getElementById('fecha_final').addEventListener('change', actualizarGrafico);
});
