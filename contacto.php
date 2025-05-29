
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="icon" href="img/logo-nutrikids2.png" type="image/png">
    <title>NUTRIKIDS</title>
</head>
<body>
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-4">Contacto</h2>
                <div class="mb-4 text-center">
                    <p>
                        "Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                        con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."
                    </p>
                    <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Datos de contacto -->
                            <div class="col-md-5 border-end mb-3 mb-md-0">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <i class="bi bi-envelope-fill me-2"></i>
                                        <strong>Vía E-mail:</strong> nutrikids.fj@gmail.com
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-instagram me-2"></i>
                                        <strong>Nuestras redes sociales:</strong> @nutrikids
                                    </li>
                                    <li>
                                        <i class="bi bi-telephone-fill me-2"></i>
                                        <strong>Por teléfono:</strong> 3244845451
                                    </li>
                                </ul>
                            </div>
                            <!-- Formulario -->
                            <div class="col-md-7">
                                <form action='PHPMailer-master/config/email_contacto.php' method="post">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre y Apellido</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe tu nombre y primer apellido" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Escribe tu e-mail" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mensaje" class="form-label">Mensaje</label>
                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje" required></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger">Enviar Mensaje</button>
                                        <a href="index.php" class="btn btn-secondary ms-2">Regresar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mapa de Google Maps -->
                <div class="mt-4">
                    <h5 class="mb-3">Ubicación</h5>
                    <div class="ratio ratio-16x9">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.690379575584!2d-75.1497437!3d4.4020729!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e38daac36ef33ef%3A0xc4167c4b60b14a15!2sSENA%20Centro%20de%20Industria%20y%20de%20la%20Construcci%C3%B3n!5e0!3m2!1ses!2sco!4v1717000000000!5m2!1ses!2sco" 
                            width="600" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
                <!-- Fin Mapa -->
            </div>
        </div>
    </main>
    <?php include "footer.html"; ?>
</body>
</html>