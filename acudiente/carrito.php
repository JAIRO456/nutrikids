
    <div class="container-modal">
        <div class="modal-content">
            <span class="close" id="close"><i class="bi bi-x-circle-fill"></i></span>
            <div class="container-students">
                <div class="col-md-6 mb-3">
                    <label for="documento_est" class="form-label">Estudiantes</label>
                    <select class="form-select" id="documento_est" name="documento_est" required>
                        <option value="">Seleccione un Estudiante</option>
                            <?php
                                $documento = $_SESSION['documento'];
                                $sqlStudents = $con->prepare("SELECT estudiantes.nombre, estudiantes.apellido FROM estudiantes 
                                INNER JOIN usuarios ON estudiantes.documento = usuarios.documento
                                WHERE usuarios.documento = ? ORDER BY nombre ASC");
                                $sqlStudents->execute([$documento]);
                                while ($row = $sqlStudents->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['documento_est']}'>{$row['nombre']} {$row['apellido']}</option>";
                                }
                            ?>
                    </select>
                </div>
            </div>
            <div class="container-days">
                <div class="col-md-6">
                    <label for="dia" class="form-label">Dias</label>
                    <form method="GET" action="">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><input type="checkbox" class="dia" id="dia" name="dia" value="lunes"> Lunes</p>
                            </div>
                            <div class="col-md-6">
                                <p><input type="checkbox" class="dia" id="dia" name="dia" value="martes"> Martes</p>
                            </div>
                            <div class="col-md-6">
                                <p><input type="checkbox" class="dia" id="dia" name="dia" value="miercoles"> Miércoles</p>
                            </div>
                            <div class="col-md-6">
                                <p><input type="checkbox" class="dia" id="dia" name="dia" value="jueves"> Jueves</p>
                            </div>
                            <div class="col-md-6">
                                <p><input type="checkbox" class="dia" id="dia" name="dia" value="viernes"> Viernes</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="modal-content-products">
                <table class="table table-bordered table-striped" id="table-carrito">
                    <thead class="table-dark">
                        <tr>
                            <th>Productos</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Total:</td>
                            <td id="total-pedidos" class="fw-bold"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        let listaProductos = [];

        function agregarProducto(id_producto, nombre_prod, precio) {
            const productoExistente = listaProductos.find(p => p.id_producto === id_producto);
            if (productoExistente) {
                productoExistente.cantidad += 1;
            } 
            else {
                listaProductos.push({ id_producto, nombre_prod, precio, cantidad: 1 });
            }
            actualizarCarrito();
        }
        function actualizarCarrito() {
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = '';
            let total = 0;
            listaProductos.forEach(producto => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${producto.nombre_prod}</td>
                    <td>${producto.cantidad}</td>
                    <td>${(producto.precio * producto.cantidad).toFixed(2)}</td>
                `;
                tableBody.appendChild(tr);
                total += parseFloat(producto.precio) * producto.cantidad;
            });
            document.getElementById('total-pedidos').textContent = total.toFixed(2);
        }

        document.getElementById('modal').addEventListener('click', function () {
            actualizarCarrito();
            document.querySelector('.container-modal').style.display = 'block';
        });
        document.getElementById('close').addEventListener('click', function () {
            document.querySelector('.container-modal').style.display = 'none';
        });
</script>