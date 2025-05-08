<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/ventas_anuales.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <div class="container-div">
            <h3>Ventas mensuales</h3>
            <canvas id="ventas-anuales" width="800" height="400"></canvas>
        </div>
    </main>
</body>
<script>

    const canvas = document.getElementById('ventas-anuales');
    const ctx = canvas.getContext('2d');

    // Datos y tiempos
    const data = [400000, 500000, 450000, 600000, 700000, 650000, 800000, 900000, 850000, 1000000];
    const times = [2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025];

    // Ajustar tamaño del canvas dinámicamente
    canvas.width = 800;
    canvas.height = 400;

    function draw() {
        // Limpiar el canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Eje Y con marcas de 100,000 hasta 5,000,000
        const maxY = 5000000;
        const step = 100000;

        ctx.strokeStyle = 'black';
        ctx.lineWidth = 1;
        for (let i = 0; i <= maxY; i += step) {
            const y = canvas.height - (i / maxY) * (canvas.height - 40); // Escalado para el eje Y
            ctx.beginPath();
            ctx.moveTo(40, y);
            ctx.lineTo(45, y); // Línea pequeña al final del eje Y
            ctx.stroke();

            // Etiqueta del valor en el eje Y
            ctx.fillText(i.toLocaleString(), 10, y + 5); // Dibujar el valor
        }

        // Dibujar la línea del gráfico
        ctx.strokeStyle = 'blue';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(50, canvas.height - (data[0] / maxY) * (canvas.height - 40)); // Escalado dinámico según el valor máximo

        // Dibujar las líneas conectando los puntos
        for (let i = 1; i < data.length; i++) {
            const x = 50 + i * 60; // Espaciado entre los puntos
            const y = canvas.height - (data[i] / maxY) * (canvas.height - 40); // Escalado
            ctx.lineTo(x, y);
        }
        ctx.stroke();

        // Dibujar los puntos en rojo
        ctx.fillStyle = 'red';
        for (let i = 0; i < data.length; i++) {
            const x = 50 + i * 60; // Espaciado entre los puntos
            const y = canvas.height - (data[i] / maxY) * (canvas.height - 40); // Escalado
            ctx.beginPath();
            ctx.arc(x, y, 5, 0, 2 * Math.PI); // Dibuja un círculo en cada punto
            ctx.fill();
        }

        // Dibujar los años en el eje X
        ctx.fillStyle = 'black';
        for (let i = 0; i < times.length; i++) {
            const x = 50 + i * 60; // Espaciado entre los puntos
            ctx.fillText(times[i], x - 10, canvas.height - 10); // Ajuste del texto
        }

        // Eje Y
        ctx.beginPath();
        ctx.moveTo(40, 0);
        ctx.lineTo(40, canvas.height);
        ctx.stroke();

        // Eje X
        ctx.beginPath();
        ctx.moveTo(40, canvas.height - 20);
        ctx.lineTo(canvas.width, canvas.height - 20);
        ctx.stroke();
    }

    // Llamar a la función para dibujar el gráfico
    draw();


</script>
</html>