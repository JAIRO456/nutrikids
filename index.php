<?php include "menu.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>NUTRIKIDS</title>
</head>
<body>
    <main class="container-main">
        <section class="container-carousel">
            <button class="button-previous" onclick="move(-1)">&#10094;</button>
            <div class="container-carousel-imgs">
                <div class="img">
                    <img src="img/alimentacion-saludable.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/productos-saludables.jpg" alt="">
                </div>
                <div class="img">
                    <img src="img/nutricionista-niño.jpeg" alt="">
                </div>
            </div>
            <button class="button-next" onclick="move(1)">&#10095;</button>
        </section>

        <section class="container-section">
            <div class="container-div1">
                <h1>A TU ALCANCE</h1>
                <h2>"Elige los mejores productos para tus hijos, asegurándote de brindarles lo mejor en su día a día, para que crezcan saludables, felices y bien cuidados."</h2>
                <p>Transforma tu método de elección de productos saludables para el cuidado de tus hijos, seleccionando opciones que realmente promuevan su bienestar y desarrollo. Al tomar decisiones más conscientes y responsables, estarás asegurando que cada producto que uses en su día a día favorezca su salud y seguridad, brindándoles lo mejor para su crecimiento.</p>
            </div>

            <div class="container-img">
                <img class="nutri" src="img/nutric.jpeg" alt="">
            </div>
        </section>

        <section class="container-section2">
            <div class="container-info">
                <h2>Mision</h2>
                <p>Nuestra misión es proporcionar una plataforma digital que permita a los padres monitorear y seleccionar productos saludables para sus hijos en los colegios, 
                optimizando las opciones alimenticias disponibles en los comedores escolares. Buscamos mejorar el rendimiento académico, la memoria y el bienestar físico de los estudiantes en preescolar, 
                primaria y bachillerato, al promover una alimentación balanceada y controlada durante su jornada escolar.</p>
            </div>

            <div class="container-info">
                <h2>Vision</h2>
                <p>Nosotros permitiremos la transformación de la alimentación escolar, contribuyendo al bienestar integral de los estudiantes y la mejora de su rendimiento académico. 
                    Motivemos a todos los colegios, tanto públicos como privados, adopten prácticas de consumo saludable y garantizando un entorno escolar más saludable para los niños y jóvenes.</p>
            </div>

            <div class="container-info">
                <h2>Valores</h2>
                <ul>
                    <li><strong>Salud y Bienestar: </strong>Promovemos una alimentación que favorezca la salud física y mental de los estudiantes, apoyando su desarrollo académico y personal.</li><br>
                    <li><strong>Colaboración: </strong>Trabajamos en conjunto con colegios, padres, nutricionistas y autoridades para promover una cultura alimenticia saludable y responsable en los entornos escolares.</li><br>
                    <li><strong>Compromiso Social: </strong>Nos comprometemos a transformar positivamente las comunidades escolares, mejorando el bienestar de los niños y jóvenes, y contribuyendo a su éxito académico.</li>
                </ul>
            </div>
        </section>
    </main>

    <?php include "footer.html"; ?>

</body>
<!-- https://st3.depositphotos.com/6723736/32546/v/450/depositphotos_325461292-stock-illustration-young-nutritionist-woman-and-ingredients.jpg -->
<script>
    let index = 0;
    let slides = document.querySelectorAll('.img');
    showSlides();

    let autoRotate = setInterval(() => {
    index++;
    showSlides();
    }, 5000);

    function showSlides() {
        if (index >= slides.length) {
            index = 0;
        }
        if (index < 0) {
            index = slides.length - 1;
        }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        slides[index].style.display = 'block';
    }

    function move(n) {
        clearInterval(autoRotate);
        index += n;
        showSlides();
        autoRotate = setInterval(() => {
        index++;
        showSlides();
        }, 5000);
    }
</script>
</html>