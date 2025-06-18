<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    require_once('../include/functions_reportes.php');
    
    $conex = new Database;
    $con = $conex->conectar();

    include 'menu.php';

    // Obtener años disponibles para el select
    $anios = obtenerAniosDisponibles($con);
    $anioActual = date('Y');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Ventas</h1>
        <form action="ventas.php" method="post">
            <label for="anio">Año:</label>
            <select name="anio" id="anio">
                <?php foreach ($anios as $anio): ?>
                    <option value="<?php echo $anio; ?>" <?php echo ($anio == $anioActual) ? 'selected' : ''; ?>>
                        <?php echo $anio; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Ventas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meses as $mes => $ventas): ?>
                    <tr>
                        <td><?php echo $mes; ?></td>
                        <td><?php echo $ventas; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 