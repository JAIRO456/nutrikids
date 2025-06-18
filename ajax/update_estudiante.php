<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento_est = $_POST['documento_est'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    
    // Manejo de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../img/users/';
        $fileExtension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $newFileName;

        // Verificar si es una imagen válida
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedTypes)) {
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                $imagen = $newFileName;
            }
        }
    }

    // Si no se subió una nueva imagen, mantener la imagen existente
    if (empty($imagen)) {
        $sql = $con->prepare("SELECT imagen FROM estudiantes WHERE documento_est = ?");
        $sql->execute([$documento_est]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        $imagen = $result['imagen'];
    }

    $sql = $con->prepare("UPDATE estudiantes SET telefono = ?, email = ?, imagen = ? WHERE documento_est = ?");
    $sql->execute([$telefono, $email, $imagen, $documento_est]);

    echo json_encode(['success' => true]);
?>