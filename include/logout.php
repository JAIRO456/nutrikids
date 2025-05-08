<?php
<<<<<<< HEAD
    session_start();
    unset($_SESSION['documento']);
    unset($_SESSION['rol']);
    unset($_SESSION['estate']);
    session_destroy();
    session_write_close();

    echo '<script>alert("Sesión cerrada");</script>';
    echo '<script>window.location = "../login.html"</script>';
    exit();
=======

if (!isset($_SESSION['documento'])){
    unset($_SESSION['documento']);
    unset($_SESSION['rol']);
    unset($_SESSION['estate']);
    $_SESSION = array();
    session_destroy();
    session_write_close();
    
    echo '<script>alert("Ingrese credenciales del Login")</script>';
    echo '<script>window.location = "../login.php"</script>';
    exit();
}

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
?>