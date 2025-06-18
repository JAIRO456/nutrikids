<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $hoy = date('Y-m-d');
    $doc = $_SESSION['documento'];
    
    $sqlPedidos = $con -> prepare("SELECT DISTINCT menus.id_menu, pedidos.id_pedidos, pedidos.fecha_ini, pedidos.fecha_fin, estados.estado, menus.nombre_menu, pedidos.id_estado FROM pedidos 
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_pedidos_producto ON pedidos.id_pedidos = detalles_pedidos_producto.id_pedido
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN estados ON pedidos.id_estado = estados.id_estado
    WHERE pedidos.documento = ? ORDER BY pedidos.id_pedidos DESC LIMIT 5");
    $sqlPedidos -> execute([$doc]);
    $pedidos = $sqlPedidos -> fetchAll(PDO::FETCH_ASSOC);

    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.imagen, estudiantes.telefono, estudiantes.email FROM estudiantes 
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = ?");
    $sqlStudent -> execute([$doc]);
    $Students = $sqlStudent -> fetchAll(PDO::FETCH_ASSOC);

    $nutrientes_est = [];
    foreach ($Students as $estudiante) {
        $documento_est = $estudiante['documento_est'];
        $sqlNutrientes = $con -> prepare("SELECT 
            SUM(i.calorias * d.cantidad) as calorias,
            SUM(i.proteinas * d.cantidad) as proteinas,
            SUM(i.carbohidratos * d.cantidad) as carbohidratos,
            SUM(i.grasas * d.cantidad) as grasas,
            SUM(i.azucares * d.cantidad) as azucares,
            SUM(i.sodio * d.cantidad) as sodio
        FROM 
            informacion_nutricional i
        INNER JOIN 
            producto p ON i.id_producto = p.id_producto
        INNER JOIN 
            detalles_pedidos_producto d ON p.id_producto = d.id_producto
        INNER JOIN 
            pedidos ped ON d.id_pedido = ped.id_pedidos
        WHERE d.documento_est = ? AND ped.id_estado = 6
        AND ped.fecha_ini = ? AND ped.fecha_fin = ?");
        $sqlNutrientes -> execute([$documento_est, $hoy, $hoy]);
        $nutrientes = $sqlNutrientes -> fetch(PDO::FETCH_ASSOC);
        
        $nutrientes_est[] = [
            'estudiante' => [
                'nombre' => $estudiante['nombre'],
                'apellido' => $estudiante['apellido']
            ],
            'nutrientes' => $nutrientes
        ];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --background-color: #f3f4f6;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: var(--background-color);
            padding-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            transition: transform var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .estudiante-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .estudiante-imagen {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .estudiante-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .estudiante-info {
            margin-top: 1rem;
        }

        .btn-action {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            margin: 0.5rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn-action:hover {
            opacity: 0.9;
        }

        .notificaciones {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .pedidos-recientes {
            margin-top: 2rem;
        }

        .pedido-item {
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }

        .pedido-item:last-child {
            border-bottom: none;
        }

        .estado-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .estado-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .estado-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }

        .estado-cancelado {
            background-color: #f8d7da;
            color: #721c24;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-top: 1rem;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            background-color: #fff;
            color: #212529;
            font-size: 0.9rem;
        }

        .modalUpdate {
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.5); 
            z-index: 1000;
        }

        .modal-content {
            background-color: white; 
            margin: 15% auto; 
            padding: 20px; 
            border-radius: 8px; 
            width: 80%; 
            max-width: 500px;
        }

        .modal-header {
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px;
        }

        .modal-body {
            margin-top: 20px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .x_input {
            position: relative;
            width: 100%;
            height: 40px;
        }

        .modal-body input {
            width: 100%;
            height: 100%;
            padding-left: 10px;
        }
        .modal-body .form_estado {
            position: absolute;
            right: 20px;
            transform: translate(10px, 10px);
        }
        .modal-body .x_typerror {
            color: red;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .x_grupo-correcto .form_estado {
            color: #1ed12d;
        }

        .x_grupo-incorrecto .form_estado {
            color: #bb2929;
        }

        .x_grupo-correcto .x_input {
            border: 3px solid #1ed12d;
        }

        .x_grupo-incorrecto .x_input {
            border: 3px solid #bb2929;
        }

        .bi-check-circle-fill {
            color: #1ed12d;
        }

        .bi-exclamation-circle-fill {
            color: #bb2929;
        }

        .x_error-block {
            display: block;
            color: red;
            font-size: 14px;
        }

        .x_typerror {
            display: none;
        }

        .x_typerror-block {
            display: block;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
            .estudiante-imagen {
                width: 100px;
                height: 100px;
            }
            .estudiante-info {
                margin-top: 0.5rem;
            }
            .chart-container {
                height: 200px;
                width: 300px;
            }
            .nutrientes-info {
                margin-top: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <!-- Sección de Notificaciones -->
        <div class="notificaciones">
            <h3><i class="fas fa-bell"></i> Notificaciones</h3>
            <?php
            $pedidosPendientes = array_filter($pedidos, function($pedido) {
                return $pedido['id_estado'] == 2;
            });
            
            if (!empty($pedidosPendientes)): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Tienes <?= count($pedidosPendientes) ?> pedidos pendientes de confirmación.
                </div>
            <?php else: ?>
                <p>No hay notificaciones pendientes.</p>
            <?php endif; ?>
        </div> 

        <!-- Sección de Estudiantes -->
        <div class="grid">
            <?php foreach ($Students as $estudiante): ?>
                <div class="card estudiante-card">
                    <div class="estudiante-imagen">
                        <?php if(!empty($estudiante['imagen'])): ?>
                            <img src="../img/users/<?= $estudiante['imagen']; ?>" alt="Foto estudiante">
                        <?php else: ?>
                            <img src="../img/users/default.png" alt="Foto por defecto">
                        <?php endif; ?>
                    </div>
                    <div class="estudiante-info">
                        <h3><?= $estudiante['nombre'] . ' ' . $estudiante['apellido']; ?></h3>
                        <p>Documento: <?= $estudiante['documento_est']; ?></p>
                        <p>Teléfono: <?= $estudiante['telefono']; ?></p>
                        <p>Email: <?= $estudiante['email']; ?></p>
                        <div class="btn-group">
                            <a href="pedidos.php?id_estudiante=<?= $estudiante['documento_est']; ?>" class="btn-action">
                                <i class="fas fa-utensils"></i> Ver Pedidos
                            </a>
                            <button type="button" class="btn btn-danger" onclick="showUpdateForm(<?= $estudiante['documento_est']; ?>)">Actualizar</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sección de Información Nutricional -->
        <div class="grid">
            <?php foreach ($nutrientes_est as $index => $estudiante): ?>
                <div class="card">
                    <h3><i class="fas fa-chart-pie"></i> Información Nutricional - <?= $estudiante['estudiante']['nombre'] ?> <?= $estudiante['estudiante']['apellido'] ?></h3>
                    <div class="chart-container">
                        <canvas id="nutrientesChart<?= $index ?>"></canvas>
                    </div>
                    <div class="nutrientes-info mt-3">
                        <h4>Resumen Nutricional del Día</h4>
                        <ul class="list-group">
                            <?php 
                            $nutrientes = $estudiante['nutrientes'] ?? [];
                            ?>
                            <li class="list-group-item">Calorías: <?= number_format($nutrientes['calorias'] ?? 0, 2) ?> kcal</li>
                            <li class="list-group-item">Proteínas: <?= number_format($nutrientes['proteinas'] ?? 0, 2) ?> g</li>
                            <li class="list-group-item">Carbohidratos: <?= number_format($nutrientes['carbohidratos'] ?? 0, 2) ?> g</li>
                            <li class="list-group-item">Grasas: <?= number_format($nutrientes['grasas'] ?? 0, 2) ?> g</li>
                            <li class="list-group-item">Azúcares: <?= number_format($nutrientes['azucares'] ?? 0, 2) ?> g</li>
                            <li class="list-group-item">Sodio: <?= number_format($nutrientes['sodio'] ?? 0, 2) ?> mg</li>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Sección de Pedidos Recientes -->
        <div class="card pedidos-recientes">
            <h3><i class="fas fa-history"></i> Pedidos Recientes</h3>
            <?php if (empty($pedidos)): ?>
                <p>No hay pedidos recientes.</p>
            <?php else: ?>
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="pedido-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Pedido #<?= $pedido['id_pedidos']; ?></h4>
                                <p><i class="fas fa-calendar"></i> Fecha: <?= date('d/m/Y', strtotime($pedido['fecha_ini'])); ?></p>
                                <p><i class="fas fa-utensils"></i> Menú: <?= $pedido['nombre_menu']; ?></p>
                                <p><i class="fas fa-circle"></i> Estado: <?= $pedido['estado']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Modal de Actualización de Información -->
        <div class="modalUpdate" id="modalUpdate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Información del Estudiante</h5>
                    <button type="button" onclick="closeModal()" class="close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form" name="form" class="form">
                        <input type="hidden" id="documento_est" name="documento_est">
                        <div class="x_grupo" id="x_telefono">
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <div class="x_input">
                                <input type="number" class="form-control" id="telefono" name="telefono" required>
                                <i class="form_estado fa fa-exclamation-circle"></i>
                            </div>
                            <p class="x_typerror">Teléfono inválido, debe ser un número de 10 dígitos.</p>
                        </div>
                        <div class="x_grupo" id="x_email">
                            <label for="email" class="form-label">Email:</label>
                            <div class="x_input">
                                <input type="email" class="form-control" id="email" name="email" required>
                                <i class="form_estado fa fa-exclamation-circle"></i>
                            </div>
                            <p class="x_typerror">Email inválido, debe ser un email válido (ejemplo: ejemplo@gmail.com).</p>
                        </div>
                        <div class="x_grupo">
                            <label for="imagen" class="form-label">Imagen:</label>
                            <div class="x_input">
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../validate/validar.js"></script>
    <script>
        try {
            const nutrientesData = <?= json_encode($nutrientes_est); ?>;
            
            nutrientesData.forEach((estudiante, index) => {
                const canvas = document.getElementById(`nutrientesChart${index}`);
                if (!canvas) {
                    console.error(`No se encontró el canvas para el índice ${index}`);
                    return;
                }

                const ctx = canvas.getContext('2d');
                const datos = estudiante.nutrientes || {};
                
                const valores = [
                    parseFloat(datos.calorias) || 0,
                    parseFloat(datos.proteinas) || 0,
                    parseFloat(datos.carbohidratos) || 0,
                    parseFloat(datos.grasas) || 0,
                    parseFloat(datos.azucares) || 0,
                    parseFloat(datos.sodio) || 0
                ];

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Calorías', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azúcares', 'Sodio'],
                        datasets: [{
                            label: estudiante.estudiante.nombre + ' ' + estudiante.estudiante.apellido,
                            data: valores,
                            backgroundColor: 'rgba(220, 53, 69, 0.5)',
                            borderColor: 'rgba(220, 53, 69, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toFixed(2);
                                    }
                                }
                            }
                        }
                    }
                });
            });
        } catch (error) {
            console.error('Error al crear las gráficas:', error);
        }

        function showUpdateForm(documento_est) {
            const estudiante = <?= json_encode($Students) ?>.find(e => e.documento_est === documento_est);
            if (estudiante) {
                document.getElementById('documento_est').value = estudiante.documento_est;
                document.getElementById('telefono').value = estudiante.telefono;
                document.getElementById('email').value = estudiante.email;
                document.getElementById('modalUpdate').style.display = 'block';
            }
        }

        function closeModal() {
            document.getElementById('modalUpdate').style.display = 'none';
        }

        document.getElementById('form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('documento_est', document.getElementById('documento_est').value);
            formData.append('telefono', document.getElementById('telefono').value);
            formData.append('email', document.getElementById('email').value);
            
            const imagenFile = document.getElementById('imagen').files[0];
            if (imagenFile) {
                formData.append('imagen', imagenFile);
            }

            try {
                const response = await fetch('../ajax/update_estudiante.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    alert('Información actualizada correctamente');
                    location.reload();
                } else {
                    alert('Error al actualizar la información');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al actualizar la información');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>