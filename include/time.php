<?php
    $time_max = 30; 

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
?>