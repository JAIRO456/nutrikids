<?php
    session_start();
    unset($_SESSION['documento']);
    unset($_SESSION['rol']);
    unset($_SESSION['estate']);
    session_destroy();
    session_write_close();

    echo '<script>alert("Sesión cerrada");</script>';
    echo '<script>window.location = "../login.html"</script>';
    exit();
?>