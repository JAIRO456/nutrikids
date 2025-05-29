<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    if (isset($_POST['enviar'])){
        $documento = $_POST['documento'];
        $password = $_POST['password'];

        if (empty($documento) || empty($password)) {
            echo '<script>alert("Existen datos vacíos")</script>';
            echo '<script>window.location = "../login.html"</script>';
            exit();
        }
<<<<<<< HEAD
        elseif (!is_numeric($documento)) {
            echo "<script>alert('Tipo de dato no requerido, en el Documento')</script>";
            echo '<script>window.location = "../login.html"</script>';
            exit();
        } 
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        else {
            $password_descr = htmlentities(addslashes($password));
            $sqlUser = $con -> prepare("SELECT * FROM usuarios WHERE documento = ?");
            $sqlUser -> execute([$documento]);
            $u = $sqlUser -> fetch();

            if ($u && password_verify($password_descr, $u["password"]) && ($u["id_estado"] == 1)) {
                $_SESSION['documento'] = $u['documento']; 
                $_SESSION['rol'] = $u['id_rol'];
                $_SESSION['estate'] = $u['id_estado'];

                    if($_SESSION['rol'] == 1){
                        header("Location: ../admin/inicio.php");
                        exit();
                    }
                    if($_SESSION['rol'] == 2 && $_SESSION['estate'] == 1){
                        header("Location: ../coordinador/inicio.php");
                        exit();
                    }
                    if($_SESSION['rol'] == 3 && $_SESSION['estate'] == 1){
                        header("Location: ../vendedor/inicio.php");
                        exit();
                    }
                    if($_SESSION['rol'] == 4 && $_SESSION['estate'] == 1){
                        header("Location: ../acudiente/inicio.php");
                        exit();
                    }
            }

            // si el usuario existe, pero está inactivo
            if ($u && ($u["id_estado"] == 2)) {
                echo '<script>alert("Usuario inactivo")</script>';
                echo '<script>window.location = "../login.html"</script>';
                exit();
            }

            // si el usuario existe, pero la contraseña no es correcta
            if ($u && !password_verify($password_descr, $u["password"])) {
                echo '<script>alert("La contraseña es incorrecta")</script>';
                echo '<script>window.location = "../login.html"</script>';
                exit();
            }
            
            // si el usuario no existe
            if (!$u) {
                echo '<script>alert("El usuario no existe")</script>';
                echo '<script>window.location = "../login.html"</script>';
                exit();
            }   
<<<<<<< HEAD
=======
=======
session_start();
require_once('../conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php

if (isset($_POST['enviar'])){
    $documento = $_POST['documento'];

    if ($documento == "" && $_POST['password'] == ""){
        echo "<script>alert('Existen datos vacios')</script>";
        echo "<script>window.location = '../login.php'</script>";
        exit();
    }

    else {

        $password_descr = htmlentities(addslashes($_POST['password']));
        $sqlUser = $con -> prepare("SELECT * FROM usuarios WHERE documento = '$documento'");
        $sqlUser -> execute();
        $u = $sqlUser -> fetch();

        if ($u && password_verify($password_descr, $u["password"]) && ($u["id_estado"] == 1)) {
            $_SESSION['documento'] = $u['documento']; 
            $_SESSION['rol'] = $u['id_rol'];
            $_SESSION['estate'] = $u['id_estado'];
            echo "Sesión iniciada correctamente: " . $_SESSION['documento'];

                if($_SESSION['rol'] == 1){
                    header("Location: ../admin/inicio.php");
                    exit();
                }

                if($_SESSION['rol'] == 2 && $_SESSION['estate'] == 1){
                    header("Location: coordinador/inicio.php");
                    exit();
                }

                if($_SESSION['rol'] == 3 && $_SESSION['estate'] == 1){
                    header("Location: ../vendedor/inicio.php");
                    exit();
                }

                if($_SESSION['rol'] == 4 && $_SESSION['estate'] == 1){
                    header("Location: ../acudiente/inicio.php");
                    exit();
                }
            }

            if ($u && ($u["id_estado"] == 2)) {
                echo '<script>alert("Usuario Inactivo")</script>';
                echo '<script>window.location = "login.php"</script>';
                exit();
            }

            if (!$u){
                echo '<script>alert("El usuario no existe")</script>';
                echo '<script>window.location = "login.php"</script>';
                exit();
            }    
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        }
    }
?>