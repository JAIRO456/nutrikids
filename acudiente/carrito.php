
    <div class="container-modal">
        <div class="modal-content">
            <span class="close" id="close"><i class="bi bi-x-circle-fill"></i></span>
            <div id="userStatsContent">
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
            listaProductos.push({ id_producto, nombre_prod, precio });
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

                    <td>${producto.precio}</td>
                `;
                tableBody.appendChild(tr);
                total += parseFloat(producto.precio);
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