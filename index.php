<?php include "menu.html"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>NUTRIKIDS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            margin: 0;
            padding-top: 7%; 
            font-family: Arial, sans-serif;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: transparent;
            max-width: 100%;
        }
        .container-carousel {
            padding-top: 1%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .button-previous, .button-next {
            background: #00b894;
            border: none;
            color: #fff;
            font-size: 2rem;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .container-carousel-imgs {
            display: flex;
            width: 100%;
            height: 350px;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            background: #fff;
            position: relative;
        }
        .img {
            min-width: 100%;
            transition: opacity 0.5s;
            display: none;
            justify-content: center;
            align-items: center;
        }
        .img img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 20px;
        }
        .button-previous, .button-next {
            background: #00b894;
            border: none;
            color: #fff;
            font-size: 2rem;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            cursor: pointer;
            transition: background 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .container-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5%;
            flex-wrap: wrap;
        }
        .container-div1 {
            flex: 1 1 350px;
        } 
        .container-div1 h1 {
            font-size: 2.8rem;
            color: #00b894;
            margin-bottom: 15px;
        }
        .container-div1 h2 {
            font-weight: bold;
            font-size: 1.5rem;
            color: #222;
            margin-bottom: 15px;
        }
        .container-div1 p {
            font-size: 1rem;
            color: #555;
        }
        .container-img {
            flex: 1 1 250px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container-img .nutri {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
            border: 4px solid #00b894;
        }
        .container-section2 {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-bottom: 40px;
        }
        .container-info {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            flex: 1 1 320px;
            min-width: 300px;
            max-width: 400px;
        }
        .container-info h2 {
            color: #00b894;
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .container-info p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .container {
                padding-top: 22%;
            }
            .container-section {
                padding: 10%;
            }
            .container-section2 {
                padding: 10%;
                padding-top: 5%;
            }
        }
    </style>
</head>
<body>
    <main class="container">
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

    <?php // include "footer.html"; ?>

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