<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>NUTRIKIDS</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-3">Contacto</h2>
                <div class=''>
                    <p>"Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                    con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."</p>
                    <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
                </div>
                <form action='PHPMailer-master/config/email_contacto.php' class="container-form" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <ul>
                                <li><strong>Vía E-mail:</strong> nutrikids@example.com</li>
                                <li><strong>Nuestras redes sociales:</strong> @nutrikids</li>
                                <li><strong>Por teléfono:</strong> 91-234-567</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Escribe tu nombre primer nombre y primer apellido" required>
                            <input type="email" class="form-control" name="email" placeholder="Escribe tu e-mail" required>
                            <textarea class="form-control" name="mensaje" placeholder="Escribe tu mensaje" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-danger">Enviar Mensaje</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include "footer.html"; ?>
</body>
</html>