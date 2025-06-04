 <?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');

    // Parámetros de paginación
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10; // Número de registros por página
    $offset = ($page - 1) * $perPage;

    if (!empty($search)) {
        $searchLike = "%$search%";
        $sqlSchools = $con->prepare("SELECT * FROM escuelas WHERE id_escuela 
        LIKE ? OR nombre_escuela LIKE ? OR email_esc LIKE ? ORDER BY nombre_escuela ASC LIMIT ? OFFSET ?");
        $sqlSchools->execute([$searchLike, $searchLike, $searchLike, $perPage, $offset]);
    } else {
        $sqlSchools = $con->prepare("SELECT * FROM escuelas ORDER BY nombre_escuela ASC LIMIT ? OFFSET ?");
        $sqlSchools->execute([$perPage, $offset]);
    }

    $listSchools = [];
    while ($school = $sqlSchools->fetch(PDO::FETCH_ASSOC)) {
        $listSchools[] = $school;
    }

    // Obtener el total de registros para calcular el número de páginas
    if (!empty($search)) {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total FROM escuelas WHERE id_escuela 
        LIKE ? OR nombre_escuela LIKE ? OR email_esc LIKE ?");
        $sqlCount->execute([$searchLike, $searchLike, $searchLike]);
    } else {
        $sqlCount = $con->prepare("SELECT COUNT(*) as total FROM escuelas");
        $sqlCount->execute();
    }

    $totalRecords = $sqlCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRecords / $perPage);

    $response = [
        'data' => $listSchools,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];

    echo json_encode($response);
    exit;
?>