<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

<<<<<<< HEAD
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlSchools = $con->prepare("SELECT * FROM escuelas WHERE id_escuela LIKE ? OR nombre_escuela LIKE ? OR email_esc LIKE ? ORDER BY nombre_escuela ASC");
        $sqlSchools->execute([$searchLike, $searchLike, $searchLike]);
    } 
    else {
        $sqlSchools = $con->prepare("SELECT * FROM escuelas ORDER BY nombre_escuela ASC");
        $sqlSchools->execute();
    }

    $listSchools = [];
    while ($school = $sqlSchools->fetch(PDO::FETCH_ASSOC)) {
        $listSchools[] = $school;
    }

=======
    $sqlSchools = $con -> prepare("SELECT * FROM escuelas ORDER BY nombre_escuela ASC;");
    $sqlSchools -> execute();

    $listAdmins = [];

    if ($sqlSchools -> rowCount() > 0) {
        while ($Schools = $sqlSchools -> fetch(PDO::FETCH_ASSOC)) {
            $listSchools[] = $Schools;
        }
    }
    
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    echo json_encode($listSchools);
?>