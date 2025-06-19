<?php
    session_start();
    require_once('../database/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];

    if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
        $id_usuario = $_GET['id_usuario'];
    }
    else {
        echo json_encode(['error' => 'Documento inválido']);
        exit;
    }

    try {
        $sqlUserCoordinador = $con->prepare("SELECT detalles_usuarios_escuela.id_escuela FROM usuarios 
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        WHERE usuarios.documento = ?");
        $sqlUserCoordinador->execute([$documento]);
        $u = $sqlUserCoordinador->fetch(PDO::FETCH_ASSOC);

        if (!$u) {
            echo json_encode(['error' => 'Coordinador no encontrado']);
            exit;
        }

        $sqlAcudiente = $con->prepare("SELECT nombre, apellido, email, telefono FROM usuarios
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        INNER JOIN roles ON usuarios.id_rol = roles.id_rol
        WHERE escuelas.id_escuela = ? AND roles.id_rol = ? AND usuarios.documento = ?");
        $sqlAcudiente->execute([$u['id_escuela'], 4, $id_usuario]);

        if ($sqlAcudiente->rowCount() > 0) {
            $acudiente = $sqlAcudiente->fetch(PDO::FETCH_ASSOC);
        } 
        else {
            $acudiente = ['error' => 'Acudiente no encontrado'];
        }
        echo json_encode($acudiente);
    } 
    catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
?>