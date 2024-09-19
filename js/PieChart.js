document.addEventListener('DOMContentLoaded', function() {
    var ctx2 = document.getElementById('PieChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Rojo', 'Azul', 'Amarillo'],
            datasets: [{
                label: 'Distribución de Colores',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});
