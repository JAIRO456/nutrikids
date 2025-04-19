<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/menus.css">
    <title>Menús</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    @include('admin.adm_menu')
    <header class="container-header">
        @auth
            <label for="" class="user">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}, {{ Auth::user()->roles->rol }}.</label>
            <a href="cuenta.php"><i class="icono bi bi-person-circle"></i></a>
        @endauth
    </header>

    <main class="container-main">
        <div class="contenido">
            <input type="search" class="search" name="search" placeholder="search">
            <i class="bi bi-search"></i>
        </div>

        <table class="container-table" id="container-table">
            <thead>
                <tr>
                    <th class="dates">IMAGEN</th>
                    <th class="dates">DOCUMENTO</th>
                    <th>NOMBRE</th>
                    <th>MENU</th>
                    <th>ESTADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>

            <tbody>
            
            </tbody>
        </table>
    </main>
</body>
    <script>
        function getMenusEstudiantes() {
            fetch('/admin/estudiantes-menus')
                .then(response => response.json())
                .then(data => {
                    const menus = data.menus;
                    const tbody = document.querySelector('#container-table tbody')
                    tbody.innerHTML = '';
            
                    menus.forEach(menu => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${menu.imagen_est}</td>
                            <td>${menu.documento_est}</td>
                            <td>${menu.nombre_est} ${menu.apellido_est}</td>
                            <td><a href="pedidos.php?id=${menu.documento_est}">menu</a></td>
                            <td>${menu.estados.estado}</td>
                            <td><a href="informacion_usuario.php?id=${menu.documento_est}"><i class="info bi bi-info-circle-fill"></i></a>
                            <a href="actualizar_user.php?id=${menu.documento_est}"><i class="update bi bi-arrow-clockwise"></i></a>
                            <a href="delete_user.php?id=${menu.documento_est}" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');"><i class="delete bi bi-x-circle-fill"></i></a></td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        setInterval(getMenusEstudiantes, 1000);
    </script>
</html>