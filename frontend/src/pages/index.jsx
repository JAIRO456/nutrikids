import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

const Index = () => {
    return (
        <main className="container-main">
            <section className="container-carousel">
                <button className="button-previous" onclick="move(-1)">&#10094;</button>
                <div className="container-carousel-imgs">
                    <div className="img">
                        <img src="img/alimentacion-saludable.jpg" alt="" />
                    </div>
                    <div className="img">
                        <img src="img/productos-saludables.jpg" alt="" />
                    </div>
                    <div className="img">
                        <img src="img/nutricionista-niño.jpeg" alt="" />
                    </div>
                </div>
                <button className="button-next" onclick="move(1)">&#10095;</button>
            </section>

            <section className="container-section">
                <div className="container-div1">
                    <h1>A TU ALCANCE</h1>
                    <h2>"Elige los mejores productos para tus hijos, asegurándote de brindarles lo mejor en su día a día, para que crezcan saludables, felices y bien cuidados."</h2>
                    <p>Transforma tu método de elección de productos saludables para el cuidado de tus hijos, seleccionando opciones que realmente promuevan su bienestar y desarrollo. Al tomar decisiones más conscientes y responsables, estarás asegurando que cada producto que uses en su día a día favorezca su salud y seguridad, brindándoles lo mejor para su crecimiento.</p>
                </div>

                <div className="container-img">
                    <img className="nutri" src="img/nutric.jpeg" alt="" />
                </div>
            </section>

            <section className="container-section2">
                <div className="container-info">
                    <h2>Mision</h2>
                    <p>Nuestra misión es proporcionar una plataforma digital que permita a los padres monitorear y seleccionar productos saludables para sus hijos en los colegios, 
                    optimizando las opciones alimenticias disponibles en los comedores escolares. Buscamos mejorar el rendimiento académico, la memoria y el bienestar físico de los estudiantes en preescolar, 
                    primaria y bachillerato, al promover una alimentación balanceada y controlada durante su jornada escolar.</p>
                </div>

                <div className="container-info">
                    <h2>Vision</h2>
                    <p>Nosotros permitiremos la transformación de la alimentación escolar, contribuyendo al bienestar integral de los estudiantes y la mejora de su rendimiento académico. 
                        Motivemos a todos los colegios, tanto públicos como privados, adopten prácticas de consumo saludable y garantizando un entorno escolar más saludable para los niños y jóvenes.</p>
                </div>

                <div className="container-info">
                    <h2>Valores</h2>
                    <ul>
                        <li><strong>Salud y Bienestar: </strong>Promovemos una alimentación que favorezca la salud física y mental de los estudiantes, apoyando su desarrollo académico y personal.</li><br />
                        <li><strong>Colaboración: </strong>Trabajamos en conjunto con colegios, padres, nutricionistas y autoridades para promover una cultura alimenticia saludable y responsable en los entornos escolares.</li><br />
                        <li><strong>Compromiso Social: </strong>Nos comprometemos a transformar positivamente las comunidades escolares, mejorando el bienestar de los niños y jóvenes, y contribuyendo a su éxito académico.</li>
                    </ul>
                </div>
            </section>
        </main>
    );
};
  
export default Index;