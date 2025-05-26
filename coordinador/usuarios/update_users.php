<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $usuario_id = $_GET['id'];
    $sqlUsuarios = $con -> prepare("SELECT * FROM usuarios 
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol 
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sqlUsuarios -> execute([$usuario_id]);
    $usuarios = $sqlUsuarios -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $imagen = $_FILES['imagen']['name'];
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];
        $id_estado = $_POST['id_estado'];
        $id_escuela = $usuarios['id_escuela'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/users/" . $imagen);
        } 
        else {
            $imagen = $usuarios['imagen'];
        }

        $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, imagen = ?, id_rol = ?, id_estado = ? WHERE documento = ?");
        $sqlUpdate->execute([$telefono, $imagen, $id_rol, $id_estado, $usuario_id]);
        echo '<script>alert("Usuario actualizado exitosamente")</script>';
        echo '<script>window.location = "../usuarios.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body onload="form.documento.focus()">
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Actualizar Usuario</h2>
                    <form id="form" method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $usuarios['documento']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuarios['nombre']; ?>" readonly>
                            </div>    
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuarios['apellido']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuarios['telefono']; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuarios['email']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_rol" class="form-label">Rol</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="<?php echo $usuarios['id_rol']; ?>"><?php echo $usuarios['rol']; ?></option>
                                    <?php
                                        $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol != ?");
                                        $sqlRoles->execute([$usuarios['id_rol']]);
                                        $roles = $sqlRoles->fetchAll();
                                        foreach ($roles as $rol) {
                                            echo "<option value='{$rol['id_rol']}'>{$rol['rol']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_estado" class="form-label">Estado</label>
                                <select class="form-select" id="id_estado" name="id_estado" required>
                                    <option value="<?php echo $usuarios['id_estado']; ?>"><?php echo $usuarios['estado']; ?></option>
                                    <?php
                                        $sqlEstados = $con->prepare("SELECT * FROM estados WHERE id_estado != ?");
                                        $sqlEstados->execute([$usuarios['id_estado']]);
                                        $estados = $sqlEstados->fetchAll();
                                        foreach ($estados as $estado) {
                                            echo "<option value='{$estado['id_estado']}'>{$estado['estado']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-danger mt-3">Actualizar Usuario</button>
                                <a href="../usuarios.php" class="btn btn-secondary mt-3">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>