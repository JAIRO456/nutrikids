<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Gráfica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .chart-container {
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
        .debug-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prueba de Gráfica Nutricional</h1>
        
        <div class="debug-info">
            <h3>Información de Debug:</h3>
            <p>ID Escuela: <?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'No proporcionado'; ?></p>
            <p>Fecha actual: <?php echo date('Y-m-d'); ?></p>
        </div>

        <div class="chart-container">
            <canvas id="nutrient"></canvas>
        </div>
        
        <div id="no-data-message" style="display: none; text-align: center; padding: 20px; color: #666;">
            No hay datos nutricionales disponibles.
        </div>
    </div>

    <script>
        // Datos de prueba
        const datosPrueba = {
            calorias: 1500,
            proteinas: 75,
            carbohidratos: 200,
            grasas: 50,
            azucares: 30,
            sodio: 1200
        };

        let nutrientChart;
        
        function crearGrafica(datos) {
            const ctx = document.getElementById('nutrient').getContext('2d');
            const noDataMessage = document.getElementById('no-data-message');
            
            if (nutrientChart) {
                nutrientChart.destroy();
            }

            const valores = [
                datos.calorias || 0,
                datos.proteinas || 0,
                datos.carbohidratos || 0,
                datos.grasas || 0,
                datos.azucares || 0,
                datos.sodio || 0
            ];

            const tieneDatos = valores.some(valor => valor > 0);

            if (!tieneDatos) {
                noDataMessage.style.display = 'block';
                return;
            }

            noDataMessage.style.display = 'none';

            nutrientChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Calorías', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azúcares', 'Sodio'],
                    datasets: [{
                        label: 'Valores Nutricionales',
                        data: valores,
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        borderColor: ['#2693e6', '#e74c3c', '#f39c12', '#16a085', '#8e44ad', '#e67e22'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Valores Nutricionales'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Nutrientes'
                            }
                        }
                    }
                }
            });
        }

        // Cargar datos reales si hay ID de escuela
        function cargarDatosReales() {
            const urlParams = new URLSearchParams(window.location.search);
            const idEscuela = urlParams.get('id');
            
            if (idEscuela) {
                fetch(`../../ajax/get_nutricion_data.php?id_escuela=${idEscuela}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Datos recibidos:', data);
                        crearGrafica(data);
                    })
                    .catch(error => {
                        console.error('Error al cargar datos:', error);
                        console.log('Usando datos de prueba...');
                        crearGrafica(datosPrueba);
                    });
            } else {
                console.log('No hay ID de escuela, usando datos de prueba...');
                crearGrafica(datosPrueba);
            }
        }
        
        // Inicializar cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarDatosReales();
        });
    </script>
</body>
</html> 