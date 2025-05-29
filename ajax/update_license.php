<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $id_escuela = $_POST['id_escuela'] ?? null;

    if ($id_escuela) {
        // sumar mas +30 dias a la fecha fin de la licencia
        $sqlSelect = $con->prepare("SELECT fecha_fin FROM licencias WHERE id_escuela = ?");
        $sqlSelect->execute([$id_escuela]);
        $row = $sqlSelect->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $fecha_fin = new DateTime($row['fecha_fin']);
            $fecha_fin->modify('+30 days');
            $nueva_fecha_fin = $fecha_fin->format('Y-m-d');

            // Actualizar la fecha fin de la licencia
            $sqlUpdate = $con->prepare("UPDATE licencias SET fecha_fin = ? WHERE id_escuela = ?");
            $sqlUpdate->execute([$nueva_fecha_fin, $id_escuela]);
            echo json_encode(['status' => 'success', 'message' => 'Licencia actualizada correctamente.', 'new_date' => $nueva_fecha_fin]);
            exit;
        } 
        else {
            echo json_encode(['status' => 'error', 'message' => 'Licencia no encontrada.']);
            exit;
        }
    } 
    else {
        echo json_encode(['status' => 'error', 'message' => 'ID de escuela no proporcionado.']);
    }
?>