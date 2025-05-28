<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
    // Obtener el conteo de productos
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM producto");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalProducts'] = $p['TotalProducts'];

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    // Obtener el conteo de usuarios
    $sqlRoles = $con->prepare("SELECT COUNT(*) AS TotalUser FROM usuarios");
    $sqlRoles->execute();
    $u = $sqlRoles->fetch();
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    $response['TotalUsers'] = $u['TotalUsers'];

    // Obtener el conteo de licencias
    $sqlProducts = $con->prepare("SELECT COUNT(*) AS TotalProducts FROM licencias");
    $sqlProducts->execute();
    $p = $sqlProducts->fetch();
    $response['TotalLicencias'] = $p['TotalLicencias'];
<<<<<<< HEAD
=======
=======
    $response['TotalUser'] = $u['TotalUser'];

    // Obtener el conteo de estudiantes
    $sqlEstudiantes = $con->prepare("SELECT COUNT(*) AS TotalEstudiantes FROM estudiantes");
    $sqlEstudiantes->execute();
    $e = $sqlEstudiantes->fetch();
    $response['TotalEstudiantes'] = $e['TotalEstudiantes'];
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

    // Obtener el conteo de escuelas
    $sqlSchools = $con->prepare("SELECT COUNT(*) AS TotalSchools FROM escuelas");
    $sqlSchools->execute();
    $s = $sqlSchools->fetch();
    $response['TotalSchools'] = $s['TotalSchools'];

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
    // Obtener el conteo de ventas, pero como no hay pues no :v

>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>