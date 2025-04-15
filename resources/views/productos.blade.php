<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index_productos.css">
    <title>Productos</title>
</head>
<body>
    @include('menu')
    <main class="container-main">
        <section class="container-productos">
            @foreach (\App\Models\Categoria::all() as $category)
                @if ($category->id_categoria < 6)
                    <div class="productos">
                        <a href="productos2.php?categoria={{ $category->id_categoria }}"><img src="img/categories/{{ $category->imagen }}" alt=""></a>
                        <h3>{{ $category->imagen }}</h3>
                    </div>
                @endif
            @endforeach
        </section>
    </main>
    @include('footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>