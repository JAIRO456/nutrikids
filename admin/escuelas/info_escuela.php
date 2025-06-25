<?php
    session_start();
    require_once('../../database/conex.php');
    require_once('../../include/validate_sesion.php');
    // require_once('../time.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_escuela = $_GET['id'];
    $sqlInfoNutriconal = $con -> prepare("SELECT 
    SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod 
    FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE pedidos.fecha_ini = CURDATE() AND pedidos.fecha_fin = CURDATE() AND pedidos.id_estado = 6 AND escuelas.id_escuela = ? AND detalles_menu.id_estado = 3");
    $sqlInfoNutriconal -> execute([$id_escuela]);
    $InfoNutric = $sqlInfoNutriconal -> fetchAll(PDO::FETCH_ASSOC);
    
    // Inicializar valores por defecto
    $total_calorias = 0;
    $total_proteinas = 0;
    $total_carbohidratos = 0;
    $total_grasas = 0;
    $total_azucares = 0;
    $total_sodio = 0;

    // Si hay datos, tomar el primer registro (ya que son SUMs)
    if (!empty($InfoNutric)) {
        $total_calorias = $InfoNutric[0]['total_cal'] ?? 0;
        $total_proteinas = $InfoNutric[0]['total_pro'] ?? 0;
        $total_carbohidratos = $InfoNutric[0]['total_car'] ?? 0;
        $total_grasas = $InfoNutric[0]['total_gras'] ?? 0;
        $total_azucares = $InfoNutric[0]['total_azu'] ?? 0;
        $total_sodio = $InfoNutric[0]['total_sod'] ?? 0;
    }

    $sqlInfoProductos = $con -> prepare("SELECT producto.nombre_prod, SUM(detalles_pedidos_producto.cantidad) AS total_cantidad
    FROM producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE pedidos.fecha_ini = CURDATE() AND pedidos.fecha_fin = CURDATE() AND pedidos.id_estado = 6 AND escuelas.id_escuela = ? 
    GROUP BY producto.nombre_prod
    ORDER BY total_cantidad DESC LIMIT 10");
    $sqlInfoProductos -> execute([$id_escuela]);
    $InfoProductos = $sqlInfoProductos -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/logo-nutrikids2.png" type="image/png">
    <title>Información Nutricional - Escuela</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .report-section {
            margin-bottom: 30px;
        }
        .report-section h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .report-section h4 {
            color: #666;
            margin-bottom: 20px;
        }
        .chart-container {
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
        .filtros {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .filtros label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filtros input {
            padding: 5px 10px;
            margin-right: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .filtros button {
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }
        .filtros button:hover {
            background-color: #0056b3;
        }
        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
            font-style: italic;
        }
        .debug-info {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 12px;
        }
        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
            .filtros input, .filtros button {
                display: block;
                margin: 5px 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="report-section">
            <h2>Reportes Nutricionales</h2>
            <h4>Distribución de Nutrientes - Escuela ID: <?php echo htmlspecialchars($id_escuela); ?></h4>        
            <div class="debug-info">
                <strong>Debug:</strong> Fecha actual: <?php echo date('Y-m-d'); ?> | 
                Datos encontrados: <?php echo count($InfoNutric); ?> registros
            </div>          
            <div class="filtros">
                <label for="fecha_ini">Fecha Inicio:</label>
                <input type="date" id="fecha_ini" name="fecha_ini">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin">
                <button onclick="filtrarGrafica()">Filtrar</button>
                <button onclick="resetFiltros()">Resetear</button>
            </div>
            <div class="chart-container">
                <canvas id="nutrient"></canvas>
            </div>
            <div id="no-data-message" class="no-data" style="display: none;">
                No hay datos nutricionales disponibles para el período seleccionado.
            </div>
        </div>
        <div class="report-section">
            <h2>Reportes de Productos mas Vendidos</h2>
            <h4>Productos mas vendidos - Escuela ID: <?php echo htmlspecialchars($id_escuela); ?></h4>
            <div class="debug-info">
                <strong>Debug:</strong> Fecha actual: <?php echo date('Y-m-d'); ?> | 
                Datos encontrados: <?php echo count($InfoProductos); ?> registros
            </div>
            <div class="filtros">
                <label for="fecha_ini">Fecha Inicio:</label>
                <input type="date" id="fecha_ini_products" name="fecha_ini_products">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" id="fecha_fin_products" name="fecha_fin_products">
                <button onclick="filtrarGraficaProductos()">Filtrar</button>
                <button onclick="resetFiltrosProductos()">Resetear</button>
            </div>
            <div class="chart-container">
                <canvas id="products"></canvas>
            </div>
            <div id="no-data-message-products" class="no-data" style="display: none;">
                No hay datos de productos disponibles para el período seleccionado.
            </div>
        </div>
    </main>

    <script>
        // Variables globales
        const id_escuela = <?php echo json_encode($id_escuela); ?>;
        let nutrientChart;
        let productsChart;

        // --- DATOS INICIALES ---
        const datosIniciales = {
            calorias: <?php echo json_encode($total_calorias); ?>,
            proteinas: <?php echo json_encode($total_proteinas); ?>,
            carbohidratos: <?php echo json_encode($total_carbohidratos); ?>,
            grasas: <?php echo json_encode($total_grasas); ?>,
            azucares: <?php echo json_encode($total_azucares); ?>,
            sodio: <?php echo json_encode($total_sodio); ?>
        };
        const datosInicialesProductos = <?php echo json_encode($InfoProductos); ?>;
        
        console.log('Datos iniciales:', datosIniciales);
     
        function actualizarGrafica(datos) {
            const ctx = document.getElementById('nutrient').getContext('2d');
            const noDataMessage = document.getElementById('no-data-message');

            if (nutrientChart) {
                nutrientChart.destroy();
            }

            // Verificar si hay datos
            const valores = [
                datos.calorias || 0, datos.proteinas || 0, datos.carbohidratos || 0,
                datos.grasas || 0, datos.azucares || 0, datos.sodio || 0
            ];

            console.log('Valores para la gráfica:', valores);

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
                        label: 'Valores Totales',
                        data: valores,
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });
        }

        function filtrarGrafica() {
            const fechaIni = document.getElementById('fecha_ini').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            if (fechaIni && fechaFin && new Date(fechaIni) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor a la fecha final');
                return;
            }
            const params = new URLSearchParams({ id_escuela });
            if (fechaIni) params.append('fecha_ini', fechaIni);
            if (fechaFin) params.append('fecha_fin', fechaFin);
            fetch(`../../ajax/get_nutricion_data.php?${params.toString()}`)
                .then(response => response.json())
                .then(data => actualizarGrafica(data))
                .catch(error => console.error('Error al filtrar nutrición:', error));
        }

        function resetFiltros() {
            document.getElementById('fecha_ini').value = '';
            document.getElementById('fecha_fin').value = '';
            actualizarGrafica(datosIniciales);
        }

        // --- LÓGICA GRÁFICA DE PRODUCTOS ---
        function actualizarGraficaProductos(datos) {
            const ctx = document.getElementById('products').getContext('2d');
            const noDataMessage = document.getElementById('no-data-message-products');
            if (productsChart) {
                productsChart.destroy();
            }
            const tieneDatos = Array.isArray(datos) && datos.length > 0;
            if (!tieneDatos) {
                noDataMessage.style.display = 'block';
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                return;
            }
            noDataMessage.style.display = 'none';
            const labels = datos.map(item => item.nombre_prod);
            const valores = datos.map(item => item.total_cantidad);
            productsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cantidad Vendida',
                        data: valores,
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'],
                        borderWidth: 1
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    scales: { 
                        y: { 
                            beginAtZero: true 
                        } 
                    } 
                }
            });
        }

        function filtrarGraficaProductos() {
            const fechaIni = document.getElementById('fecha_ini_products').value;
            const fechaFin = document.getElementById('fecha_fin_products').value;
            if (fechaIni && fechaFin && new Date(fechaIni) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor a la fecha final');
                return;
            }
            const params = new URLSearchParams({ id_escuela });
            if (fechaIni) params.append('fecha_ini', fechaIni);
            if (fechaFin) params.append('fecha_fin', fechaFin);
            fetch(`../../ajax/get_products_data.php?${params.toString()}`)
                .then(response => response.json())
                .then(data => actualizarGraficaProductos(data))
                .catch(error => console.error('Error al filtrar productos:', error));
        }

        function resetFiltrosProductos() {
            document.getElementById('fecha_ini_products').value = '';
            document.getElementById('fecha_fin_products').value = '';
            actualizarGraficaProductos(datosInicialesProductos);
        }

        // --- INICIALIZACIÓN ---
        document.addEventListener('DOMContentLoaded', function() {
            actualizarGrafica(datosIniciales);
            actualizarGraficaProductos(datosInicialesProductos);
        });
    </script>
</body>
</html>