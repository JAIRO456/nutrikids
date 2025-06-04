    <style>
        .cart-table th, .cart-table td {
            vertical-align: middle;
        }
        .quantity-input {
            width: 70px;
        }
        .cart-table {
            overflow: auto;
            height: 300px;
        }
        .cart-button {
            width: 150px;
            height: 100px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
    <div class="container-modal mt-1">
        <!-- Botón para abrir el modal del carrito -->
        <button type="button" class="btn btn-danger cart-button" data-bs-toggle="modal" data-bs-target="#cartModal">
            <i class="bi bi-cart-fill"></i> Carrito (<span id="cart-count">0</span>)
        </button>

        <!-- Modal del carrito -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <form id="menuForm" method="POST" action="menus.php">
                                <div class="container-div card mb-1">
                                    <button type="submit" class="btn btn-primary">Crear Menu</button>
                                </div>
                                <div class="container-div mb-3" id="container-div">
                                    <label for="nombre_menu" class="form-label">Nombre del Menu</label>
                                    <textarea type="varchar" class="form-control" id="nombre_menu" name="nombre_menu" required></textarea>
                                </div>
                                <input type="hidden" name="productos" id="productos">
                                <table class="table cart-table">
                                    <thead class='text-center'>
                                        <tr>
                                            <th>Productos</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body" class='text-center'>

                                    </tbody>
                                    <tfoot class='text-center'>
                                        <tr>
                                            <td colspan="2" class="text-end fw-bold">Total:</td>
                                            <td id="total-pedidos" class="fw-bold"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="checkout()">Pagar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let listaProductos = [];

        // Cargar productos desde localStorage al iniciar
        function cargarProductos() {
            const productosGuardados = localStorage.getItem('carrito');
            if (productosGuardados) {
                listaProductos = JSON.parse(productosGuardados);
            }
            actualizarCarrito();
        }
        function guardarProductos() {
            localStorage.setItem('carrito', JSON.stringify(listaProductos));
        }

        function agregarProducto(id_producto, nombre_prod, precio) {
            const productoExistente = listaProductos.find(p => p.id_producto === id_producto);
            if (productoExistente) {
                productoExistente.cantidad += 1;
            } 
            else {
                listaProductos.push({ id_producto, nombre_prod, precio, cantidad: 1 });
            }
            guardarProductos(); // Guardar en localStorage
            actualizarCarrito();
            getMenu();
        }

        function eliminarProducto(id_producto) {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                listaProductos = listaProductos.filter(p => p.id_producto !== id_producto);
                guardarProductos();
                actualizarCarrito();
            }
        }

        function vaciarCarrito() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                listaProductos = [];
                guardarProductos();
                actualizarCarrito();
            }
        }

        function actualizarCarrito() {
            const tableBody = document.getElementById('table-body');
            const cartCount = document.getElementById('cart-count');
            tableBody.innerHTML = '';
            let total = 0;
            listaProductos.forEach(producto => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${producto.nombre_prod}</td>
                    <td>${producto.cantidad}</td>
                    <td>${(producto.precio * producto.cantidad).toFixed(2)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="eliminarProducto(${producto.id_producto})">Eliminar</button></td>
                `;
                tableBody.appendChild(tr);
                total += parseFloat(producto.precio) * producto.cantidad;
            });
            document.getElementById('total-pedidos').textContent = total.toFixed(2);
            cartCount.textContent = listaProductos.reduce((sum, p) => sum + p.cantidad, 0); // Actualizar contador
        }
        document.getElementById('menuForm').addEventListener('submit', function(e) {
            document.getElementById('productos').value = JSON.stringify(listaProductos);
        })

        // Cargar productos al iniciar la página
        window.addEventListener('load', cargarProductos);
    </script>