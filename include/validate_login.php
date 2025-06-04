<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    header('Content-Type: application/json');

    $response = ['success' => false, 'message' => '', 'redirect' => ''];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = isset($_POST['documento']) ? trim($_POST['documento']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        if (empty($documento) || empty($password)) {
            $response['message'] = 'Existen datos vacíos';
            echo json_encode($response);
            exit();
        } 
        elseif (!is_numeric($documento)) {
            $response['message'] = 'Tipo de dato no requerido, en el Documento';
            echo json_encode($response);
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

                $response['success'] = true;
                $response['message'] = 'Login exitoso';

                if ($_SESSION['rol'] == 1) {
                    $response['message'] = 'Login exitoso';
                    $response['redirect'] = '../nutrikids/admin/inicio.php';
                } 
                elseif ($_SESSION['rol'] == 2 && $_SESSION['estate'] == 1) {
                    $response['message'] = 'Login exitoso';
                    $response['redirect'] = '../nutrikids/coordinador/inicio.php';
                } 
                elseif ($_SESSION['rol'] == 3 && $_SESSION['estate'] == 1) {
                    $response['message'] = 'Login exitoso';
                    $response['redirect'] = '../nutrikids/vendedor/inicio.php';
                } 
                elseif ($_SESSION['rol'] == 4 && $_SESSION['estate'] == 1) {
                    $response['message'] = 'Login exitoso';
                    $response['redirect'] = '../nutrikids/acudiente/inicio.php';
                }
                echo json_encode($response);
                exit();
            }
            // Si el usuario existe, pero está inactivo
            if ($u && ($u["id_estado"] == 2)) {
                $response['message'] = 'Usuario inactivo';
                echo json_encode($response);
                exit();
            }
            // Si el usuario existe, pero la contraseña no es correcta
            if ($u && !password_verify($password_descr, $u["password"])) {
                $response['message'] = 'La contraseña es incorrecta';
                echo json_encode($response);
                exit();
            }
            // Si el usuario no existe
            else {
                $response['message'] = 'El usuario no existe';
                echo json_encode($response);
                exit();
            }  
        }
    }
    else {
        $response['message'] = 'Método no permitido';
        echo json_encode($response);
    }
?>