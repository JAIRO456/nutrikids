<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link rel="stylesheet" href="../styles/roles.css">
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

        <table class="table" id='table'>
            <thead>
                <tr>
                    <th class="dates">Imagen</th>
                    <th class="dates">Documento</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th class="dates">Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</body>
    <script>
        function getRolesUsers() {
            fetch('/admin/user-roles')
                .then(response => response.json())
                .then(data => {
                    const users = data.users;
                    const tbody = document.querySelector('#table tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${user.imagen}</td>
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td>${user.roles.rol}</td>
                            <td>${user.estados.estado}</td>
                            <td><a href="informacion_usuario.php?id=${user.documento}"><i class="info bi bi-info-circle-fill"></i></a>
                            <a href="actualizar_user.php?id=${user.documento}"><i class="update bi bi-arrow-clockwise"></i></a>
                            <a href="delete_user.php?id=${user.documento}" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');"><i class="delete bi bi-x-circle-fill"></i></a></td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        setInterval(getRolesUsers, 1000);
    </script>
</html>