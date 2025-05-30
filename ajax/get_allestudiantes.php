<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
    
    if ($sql->execute([$documento])) {
        $u = $sql->fetch(PDO::FETCH_ASSOC);
        
        if (!empty($search)) {
            $searchLike = "%$search%";
            $sqlestudiantes = $con->prepare("SELECT estudiantes.imagen, estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido, estados.estado FROM estudiantes
            INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
            INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
            INNER JOIN estados ON estudiantes.id_estado = estados.id_estado
            WHERE detalles_estudiantes_escuela.id_escuela = ? AND (estudiantes.documento_est LIKE ? OR estudiantes.nombre LIKE ? OR estudiantes.apellido LIKE ?) ORDER BY documento_est ASC");
            $sqlestudiantes->execute([$u['id_escuela'], $searchLike, $searchLike, $searchLike]);
        }
        else {
            $sqlestudiantes = $con->prepare("SELECT estudiantes.imagen, estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido, estados.estado FROM estudiantes
            INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
            INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
            INNER JOIN estados ON estudiantes.id_estado = estados.id_estado
            WHERE detalles_estudiantes_escuela.id_escuela = ? ORDER BY documento_est ASC");
            $sqlestudiantes->execute([$u['id_escuela']]);
        }

        $listestudiantes = [];
        while ($estudiantes = $sqlestudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listestudiantes[] = $estudiantes;
        }

        if (!empty($listestudiantes)) {
            echo json_encode($listestudiantes);
            exit;
        } 
        else {
            echo json_encode(['error' => 'No se encontraron estudiantes']);
            exit;
        }
    } 
    else {
        echo json_encode(['error' => 'Error al obtener los datos del usuario']);
        exit;
    }
?>