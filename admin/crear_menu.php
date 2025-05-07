<?php
// include "adm_menu.html";
// include "header_user.php";

$conex = new Database;
$con = $conex->conectar();

$estado = 3;
?>

<?php
    // $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela WHERE usuarios.documento = 1234567891");
    $sql -> execute();
    $u = $sql -> fetch();
?>


<?php
    if (isset($_POST['enviar']) && !empty($_POST['productos'])) {
        $productos = $_POST['productos'];

        if (empty($productos)) {
            echo "<script>alert('Por favor, complete todos los datos.')</script>";
        } 
        
        else {
            $idEstudiante = $_POST['estudiantes'];
            $name_menu = $_POST['name_menu'];
            $idPedidos = $_POST['pedidos'];

            $sqlMenu = $con->prepare("INSERT INTO menus (nombre_menu) VALUES ('$name_menu')");
            $sqlMenu->execute();
            $idMenu = $con->lastInsertId();

            foreach ($productos as $idProducto) {
                // Verificar si el menú ya existe para el estudiante
                $sqlVerif = $con->prepare("SELECT * FROM detalles_menu WHERE id_producto = '$idProducto' AND documento_est = '$idEstudiante'");
                $sqlVerif->execute();
                $verif = $sqlVerif->fetchAll(PDO::FETCH_ASSOC);

                if ($verif) {
                    // Si existe, actualizar la cantidad
                    $sqlUpdate = $con->prepare("UPDATE detalles_menu SET cantidad = cantidad + 1 WHERE id_producto = '$idProducto' AND documento_est = '$idEstudiante' AND id_menu = '$idMenu'");
                    $sqlUpdate->execute();
                } else {
                    // Si no existe, insertar un nuevo registro
                    $sqlMenu3 = $con->prepare("INSERT INTO detalles_menu (cantidad, documento_est, id_menu, id_producto, id_pedidos, id_estado) VALUES (1, '$idEstudiante', '$idMenu', '$idProducto', '$idPedidos', '$estado')");
                    $sqlMenu3->execute();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/crear_menu.css">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main id="user_menu" class="container-main-crear_menu">
        <form id="user_menu2" action="" method="post">
            <!-- Sección para seleccionar el estudiante -->
                <div class="container-students">
                    <h3>Seleccione el estudiante</h3>
                    <select name="estudiantes" id="estudiantes">
                        <option value="">---</option>
                        <?php
                            $sqlEstudiante = $con->prepare("SELECT * FROM estudiantes INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = $u[documento]");
                            $sqlEstudiante->execute();
                            $e = $sqlEstudiante->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($e as $estudiante) {
                        ?>
                            <option value="<?php echo $estudiante['documento_est']; ?>"><?php echo $estudiante['nombre_est']; ?> <?php echo $estudiante['apellido_est']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="container-day">
                    <h3>Seleccione el día</h3>
                    <select name="pedidos" id="pedidos">
                        <option value="">---</option>
                        <?php
                            $sqlPedidos = $con->prepare("SELECT * FROM pedidos");
                            $sqlPedidos->execute();

                            while ($ped = $sqlPedidos->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value=" . $ped["id_pedidos"] . ">" . $ped["dias_sem"] . "</option>";
                            }
                        ?>
                    </select>
                </div>

                <div class="container-name-menu">
                    <h3>Nombre del menú:</h3>
                    <input type="varchar" name="name_menu" id="name_menu" placeholder="Menu de abc123">
                </div>

                <div class="div-button">
                    <button type="submit" name="enviar" class="enviar">Enviar</button>
                </div>

            <!-- Contenedor donde se mostrarán los productos seleccionados -->
            <section class="productos_seleccionados" id="productos_seleccionados">
                <table id="tabla-productos" class="table">
                    <!-- Los encabezados se agregarán solo una vez -->
                    <thead>
                        
                    </thead>
                    <tbody>
                        <!-- Aquí aparecerán los productos seleccionados -->
                    </tbody>
                </table>
            </section>

        </form>
    </main>
</body>
<script>

    function agregarProducto(idProducto, nombre, precio) {
        // Agregar el producto a la tabla

                const tbody = document.querySelector('#tabla-productos tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${nombre}</td>
                    <td>${precio}</td>
                    <td><button type="button" onclick="eliminarProducto(this, ${idProducto})">Eliminar</button></td>
                `;
                tbody.appendChild(tr);
    }

    function eliminarProducto(boton, idProducto) {
        // Eliminar la fila del producto de la tabla
        boton.parentElement.parentElement.remove();
    }

    // Función que muestra el menu al hacer clic en el botón
    function mostrarMenu() {
      const usermenu = document.getElementById('user_menu');

      if (usermenu.style.display === "none" || usermenu.style.display === "") {
        usermenu.style.display = "block";
      } else {
        usermenu.style.display = "none";
      }
    }
</script>
</html>
