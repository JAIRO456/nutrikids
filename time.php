<?php
<<<<<<< HEAD
    $time_max = 15; 

    if (isset($_SESSION['documento'])) {
        if (isset($_SESSION['last_activity'])) {
            $seconds_inactive = time() - $_SESSION['last_activity'];
            if ($seconds_inactive > $time_max) {
                unset($_SESSION['documento']);
                unset($_SESSION['rol']);
                unset($_SESSION['estate']);
                $_SESSION = array();
                session_destroy();
                session_write_close();

                echo '<script>alert("Tu sesión ha expirado por inactividad.")</script>';
                echo '<script>window.location = "../login.html"</script>';
                exit();
            }
        }
        $_SESSION['last_activity'] = time();
    } 
    else {
        header("Location: login.php");
        exit();
    }
=======

require_once('conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php

$inactividad_max = 300; 

// Verificar si ya existe una marca de tiempo de actividad
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();  // Marca de tiempo de la última actividad
}

// Calcular el tiempo de inactividad
$inactividad = time() - $_SESSION['last_activity'];

// Si la inactividad supera el tiempo máximo, el usuario se considera inactivo
if ($inactividad > $inactividad_max) {
    echo "<img src='img/users/user.png' class='imagen' alt=''>";
} else {
    echo "<img src='img/users/user2.png' class='imagen' alt='' width='50'>";
}

// Actualizamos la última actividad con la hora actual
$_SESSION['last_activity'] = time();

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
?>