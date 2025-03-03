document.addEventListener('DOMContentLoaded', function() {
    var ctxGanancias = document.getElementById('gananciasChart').getContext('2d');
    var gananciasChart = new Chart(ctxGanancias, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Ganancias',
                data: [1200, 1900, 3000, 5000, 2300, 3400],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxAportes = document.getElementById('aportesChart').getContext('2d');
    var aportesChart = new Chart(ctxAportes, {
        type: 'pie',
        data: {
            labels: ['Contador 1', 'Contador 2', 'Contador 3', 'Contador 4'],
            datasets: [{
                label: 'Aportes',
                data: [300, 50, 100, 150],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' USD';
                        }
                    }
                }
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const contadorCards = document.querySelectorAll('.contador-card');

    contadorCards.forEach(card => {
        const reviews = card.querySelectorAll('.review-card');
        let currentIndex = 0;

        function rotateReviews() {
            reviews.forEach((review, index) => {
                review.classList.remove('active'); // Ocultar todas las reseñas
                if (index >= currentIndex && index < currentIndex + 3) {
                    review.classList.add('active'); // Mostrar las 3 reseñas
                }
            });

            currentIndex = (currentIndex + 3) % reviews.length; // Avanzar 3 reseñas
        }

        rotateReviews();
        setInterval(rotateReviews, 5000); // Cambiar las reseñas cada 5 segundos
    });
});
