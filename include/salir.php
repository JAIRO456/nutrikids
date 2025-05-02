<?php

session_start();
unset($_SESSION['documento']);
unset($_SESSION['rol']);
unset($_SESSION['estate']);
session_destroy();
session_write_close();

header("Location: ../login.php");
exit();

?>