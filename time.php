<?php

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

?>