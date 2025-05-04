<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    header('Access-Control-Allow-Origin: http://localhost:3000'); // Permitir solicitudes desde el frontend
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Métodos permitidos
    header('Access-Control-Allow-Headers: Content-Type'); // Encabezados permitidos

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $documento = $input['documento'] ?? ''; // Cambiar $_POST por $input
        $password = $input['password'] ?? '';  // Cambiar $_POST por $input

        if (empty($documento) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Existen datos vacíos']);
            exit();
        }

        else {
            $password_descr = htmlentities(addslashes($password));
            $sqlUser = $con -> prepare("SELECT * FROM usuarios WHERE documento = ?");
            $sqlUser -> execute([$documento]);
            $u = $sqlUser -> fetch();

            if ($u && password_verify($password_descr, $u["password"]) && ($u["id_estado"] == 1)) {
                $_SESSION['documento'] = $u['documento']; 
                $_SESSION['rol'] = $u['id_rol'];
                $_SESSION['estate'] = $u['id_estado'];

                echo json_encode(['success' => true, 'message' => 'Sesión iniciada correctamente', 'rol' => $u['id_rol']]);
                exit();
            }

            // si el usuario existe, pero está inactivo
            if ($u && ($u["id_estado"] == 2)) {
                echo json_encode(['success' => false, 'message' => 'Usuario inactivo']);
                exit();
            }

            // si el usuario existe, pero la contraseña no es correcta
            if ($u && !password_verify($password_descr, $u["password"])) {
                echo json_encode(['success' => false, 'message' => 'La contraseña es incorrecta']);
                exit();
            }
            
            // si el usuario no existe
            if (!$u) {
                echo json_encode(['success' => false, 'message' => 'El usuario no existe']);
                exit();
            }
        }
    }
?>