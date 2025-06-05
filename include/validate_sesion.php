<?php
    if (!isset($_SESSION['documento'])){
        unset($_SESSION['documento'], $_SESSION['rol'], $_SESSION['estate']);
        $_SESSION = array();
        session_destroy();
        session_write_close();

        echo '<script>alert("Ingrese credenciales del Login")</script>';
        echo '<script>window.location = "../login.html"</script>';
        exit();
    }
?>