<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

<<<<<<< HEAD
=======
    // Obtener el conteo de productos
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM producto");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalProducts'] = $p['TotalProducts'];

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
    // Obtener el conteo de usuarios
    $sqlRoles = $con->prepare("SELECT COUNT(*) AS TotalUser FROM usuarios");
    $sqlRoles->execute();
    $u = $sqlRoles->fetch();
<<<<<<< HEAD
    $response['TotalUsers'] = $u['TotalUsers'];

    // Obtener el conteo de licencias
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM licencias");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalLicencias'] = $p['TotalLicencias'];
=======
    $response['TotalUser'] = $u['TotalUser'];

    // Obtener el conteo de estudiantes
    $sqlEstudiantes = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM estudiantes");
    $sqlEstudiantes->execute();
    $e = $sqlEstudiantes->fetch();
    $response['TotalEstudiantes'] = $e['TotalEstudiantes'];
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22

    // Obtener el conteo de escuelas
    $sqlSchools = $con->prepare("SELECT COUNT(*) AS TotalSchools FROM escuelas");
    $sqlSchools->execute();
    $s = $sqlSchools->fetch();
    $response['TotalSchools'] = $s['TotalSchools'];

<<<<<<< HEAD
=======
    // Obtener el conteo de ventas, pero como no hay pues no :v

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>