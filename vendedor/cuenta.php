<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// Obtener documento de la sesión
$doc = $_SESSION['documento'];

// Consulta para obtener los datos del usuario
$sql = $con->prepare("SELECT usuarios.*, roles.rol, estados.estado 
    FROM usuarios 
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado 
    WHERE usuarios.documento = ?");
$sql->execute([$doc]);
$usuario = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <?php include "menu.php"; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="bi bi-person-circle"></i> Mi Cuenta</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 text-center">
                                <?php if (!empty($usuario['imagen'])): ?>
                                    <img src="../img/<?= htmlspecialchars($usuario['imagen']) ?>" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                <?php else: ?>
                                    <img src="../img/users" alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Documento</th>
                                        <td><?= htmlspecialchars($usuario['documento']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Apellido</th>
                                        <td><?= htmlspecialchars($usuario['apellido']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Teléfono</th>
                                        <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Rol</th>
                                        <td><?= htmlspecialchars($usuario['rol']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Estado</th>
                                        <td><?= htmlspecialchars($usuario['estado']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="text-end">
                            <!-- <a href="editar_cuenta.php" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Editar Perfil</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>