<?php
    session_start();
    require_once('../../conex/conex.php');
    // include "adm_menu.html";
    // include "header_user.php";
    // include "../time.php";
    $conex =new Database;
    $con = $conex->conectar();

    $usuario_id = $_GET['id'];
    $sqlUsuarios = $con -> prepare("SELECT * FROM usuarios
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol 
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    WHERE usuarios.documento = ?");
    $sqlUsuarios -> execute([$usuario_id]);
    $usuarios = $sqlUsuarios -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $imgen = $_FILES['imagen']['name'];
        // $temp = $_FILES['imagen']['tmp_name'];
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];
        $id_estado = $_POST['id_estado'];
        $id_escuela = $_POST['id_escuela'];

        $sqlUpdatePaquete = $con -> prepare("UPDATE usuarios SET telefono = ?, telefono = ?, imagen = ?, id_rol = ?, id_estado = ? WHERE documento = ?");
        $sqlUpdatePaquete -> execute([$telefono, $imgen, $id_rol, $id_estado, $usuario_id]);
        echo '<script>alert("Cliente Actualizado")</script>';
        echo '<script>window.location = "../lista_clientes.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Crear Administrador</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $usuarios['documento']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuarios['nombre']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuarios['apellido']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuarios['email']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuarios['telefono']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-select" id="id_rol" name="id_rol" value="<?php echo $usuarios['id_rol']; ?>">
                                <option value="">Seleccione un rol</option>
                                <?php
                                    $sqlRoles = $con->prepare("SELECT * FROM roles");
                                    $sqlRoles->execute();
                                    while ($row = $sqlRoles->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_rol']}'>{$row['rol']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_estado" class="form-label">Estado</label>
                            <select class="form-select" id="id_estado" name="id_estado" value="<?php echo $usuarios['id_estado']; ?>">
                                <option value="">Seleccione un estado</option>
                                <?php
                                    $sqlEstados = $con->prepare("SELECT * FROM estados");
                                    $sqlEstados->execute();
                                    while ($row = $sqlEstados->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_estado']}'>{$row['estado']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_escuela" class="form-label">Escuela</label>
                            <select class="form-select" id="id_escuela" name="id_escuela" value="<?php echo $usuarios['id_escuela']; ?>">
                                <option value="">Seleccione una escuela</option>
                                <?php
                                    $sqlEscuelas = $con->prepare("SELECT * FROM escuelas");
                                    $sqlEscuelas->execute();
                                    while ($row = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_escuela']}'>{$row['nombre_escuela']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-danger">Actualizar Administrador</button>
                        <a href="../administradores.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>