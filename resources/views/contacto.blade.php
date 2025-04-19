<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index_contacto.css">
    <title>NUTRIKIDS</title>
</head>
<body>
    @include('menu')
    <main class="container-main">
        <section class="container-section">
            <div class="container-div">
                <h1>Contacto</h1> 
                <p>"Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                    con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."</p>
                <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
            </div>

            <div class="container-div2">
                <div class="contacto">
                    <ul>
                        <li><strong>Vía E-mail:</strong> nutrikids@example.com</li>
                        <li><strong>Nuestras redes sociales:</strong> @nutrikids</li>
                        <li><strong>Por teléfono:</strong> 91-234-567</li>
                    </ul>
                </div>

                <form class="container-form" method="post">
                    <input type="text" name="nombre" placeholder="Escribe tu nombre primer nombre y primer apellido" required>
                    <input type="email" name="email" placeholder="Escribe tu e-mail" required>
                    <input type="tel" name="telefono" placeholder="Escribe tu teléfono (Opcional)">
                    <select name="escuela" class="escuela" id="escuela">
                        <option value="">---</option>
                        @foreach (\App\Models\Escuela::all() as $c)
                            <option value="{{ $c->id_escuela }}">{{ $c->nombre_escuela }}</option>";
                        @endforeach
                    </select>
                    <textarea class="mensaje" name="mensaje" placeholder="Escribe tu mensaje" required></textarea>
                    <button type="submit" name="enviar" class="enviar">Enviar Mensaje</button>
                </form>
            </div>
        </section>
    </main>
    @include('footer')
</body>
</html>