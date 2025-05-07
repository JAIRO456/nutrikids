<?php
    if (!isset($_SESSION['documento'])){
        unset($_SESSION['documento']);
        unset($_SESSION['rol']);
        unset($_SESSION['estate']);
        $_SESSION = array();
        session_destroy();
        session_write_close();

        echo '<script>alert("Ingrese credenciales del Login")</script>';
        echo '<script>window.location = "../login.html"</script>';
        exit();
    }
?>