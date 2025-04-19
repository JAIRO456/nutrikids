<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('../css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>LOGIN</title>
</head>
<body>
    <header class="container-header">
        <div class="container-logo-header">
            <a href="{{ url('/') }}"><img class="logo" src="img/logo-nutrikids.png" alt=""></a>
        </div>
    </header>
    
    <main class="container-main">
        <section class="container-section">
            <h1 class="title">NUTRIKIDS</h1>
            <p class="subtitle">"Elige sabiamente para garantizar el bienestar y el futuro de tus hijos, tomando decisiones que les brinden un ambiente seguro, amoroso y lleno de oportunidades para su desarrollo integral."</p>
        </section>

        <section class="container-section2">
            <h1 class="title2">INICIO SESION</h1>
            <form action="{{ route('submit.login') }}" method="post" name="form1" id="form1" class="form1">
                @csrf
                <div class="x_grupo" id="x_documento">
                    <label for="documento">Documento</label>
                    <div class="x_input">
                        <input type="number" id="documento" name="documento" placeholder="Ingrese su documento">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Documento inválido</p>
                </div>

                <div class="x_grupo" id="x_password">
                    <label for="password">Contraseña</label>
                    <div class="x_input">
                        <input type="password" id="password" name="password" placeholder="Ingrese tu contraseña">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Contraseña inválido</p>
                </div>

                <button type="submit" name="enviar" id="botton">ENVIAR</button>
                <button type="button" onclick="window.location='{{ url('/') }}'" class="btn red">REGRESAR</button>
            </form>
        </section>
    </main>

    <footer class="container-footer">
        <p class="container-p">"Mantener una alimentación saludable no solo contribuye a un bienestar inmediato, sino que también juega un papel fundamental en la prevención de enfermedades crónicas a largo plazo, 
            mejorando tu calidad de vida y fortaleciendo el sistema inmunológico para enfrentar los desafíos del futuro. :D"</p>
    </footer>
</body>
    <!-- <script src="{{ asset('validate/validar.js') }}"></script> -->
</html>