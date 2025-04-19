<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos.css">
    <title>Productos</title>
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
        <section class="container1">
            @foreach ($categories as $category)
            <div class="productos">
                <a href="productos1.php?categoria={{ $category->id_categoria }}"><img src="../img/categories/{{ $category->imagen }}" alt=""></a>
                <h3>{{ $category->categoria }}</h3>
            </div>
            @endforeach

            <div class="productos">
                <a href="agregar_productos.php"><img src="../img/agregar_productos.png" alt=""></a>
                <h3>AGREGAR</h3>
            </div>
        </section>
    </main>
</body>
</html>