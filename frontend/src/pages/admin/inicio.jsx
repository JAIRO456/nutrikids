import React, { useEffect, useState } from 'react';
// import { useNavigate } from 'react-router-dom';

function AdminInicio() {
    return (
        <main class="container-main">
            <div class="container1">
                <h3>Cantidad de registros:</h3>
                <section class="container-section">
                    <div class="container-div1">
                        <i class="bi bi-basket-fill"></i>
                        <h1>Productos</h1>
                        <div id="totalProducts">

                        </div>
                    </div>
                    <div class="container-div1">
                        <i class="bi bi-person-lines-fill"></i>
                        <h1>Usuarios</h1>
                        <div id="totalUsers">

                        </div>
                    </div>
                    <div class="container-div1">
                        <i class="bi bi-person-fill"></i>
                        <h1>Estudiantes</h1>
                        <div id="totalEstudiantes">

                        </div>
                    </div>
                    <div class="container-div1">
                        <i class="bi bi-house-fill"></i>
                        <h1>Escuelas</h1>
                        <div id="totalSchools">

                        </div>
                    </div>
                    <div class="container-div1">
                        <i class="bi bi-activity"></i>
                        <h1>Ventas</h1>
                        <div id="totalVentas">
                            <h1>---</h1>
                        </div>
                    </div>
                </section>
            </div>

            <div class="container3">
                <h3>Usuarios Recientes</h3>
                <table class="table" id="table-users">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="container3">
                <h3>Productos Recientes</h3>
                <table class="table" id="table-products">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </main>
    );
}

export default AdminInicio;