<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $data = json_decode(file_get_contents('php://input'), true);

    $documento_est = $data['documento_est'];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $telefono = $data['telefono'];
    $email = $data['email'];
    $imagen = $data['imagen'];

    $sql = $con -> prepare("UPDATE estudiantes SET nombre = ?, apellido = ?, telefono = ?, email = ?, imagen = ? WHERE documento_est = ?");
    $sql -> execute([$nombre, $apellido, $telefono, $email, $imagen, $documento_est]);

    echo json_encode(['success' => true]);
?>