    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #e74c3c;
            --accent-color: #3498db;
            --text-color: #2c3e50;
            --background-color: #ecf0f1;
            --shadow-color: rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .cart-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 180px;
            height: 60px;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 1.2em;
            z-index: 1000;
        }

        .cart-button:hover {
            box-shadow: 0 8px 15px var(--shadow-color);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
            z-index: 1001;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 900px;
            height: 90%;
            margin: auto;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow-y: auto;
        }

        .modal-header {
            padding: 5px;
            border-bottom: 2px solid var(--background-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary-color);
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .modal-title {
            font-size: 18px;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 2em;
            cursor: pointer;
            color: white;
        }

        .cart-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
        }

        .cart-table th, .cart-table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid var(--background-color);
        }

        .cart-table th {
            background: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        .cart-table tr:hover {
            background: var(--background-color);
        }

        .form-group {
            margin: 5px;
            position: relative;
            place-items: center;
        }
        .form-group-button{
            margin: 5px;
            position: relative;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: end;
            gap: 10px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-color);
            font-weight: 500;
            font-size: 1.1em;
        }

        .form-control {
            max-width: 800px;
            max-height: 40px;
            padding: 12px;
            border: 3px solid var(--background-color);
            border-radius: 10px;
            font-size: 1em;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }

        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 20px;
            background: var(--background-color);
        }

        .checkbox-label:hover {
            background: var(--accent-color);
            color: white;
        }

        .checkbox-input {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color);
            border-radius: 6px;
            cursor: pointer;
            position: relative;
        }

        .checkbox-input:checked {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }

        .checkbox-input:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 14px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            font-size: 1.1em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: var(--accent-color);
            color: white;
        }

        .btn-danger {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary {
            background: var(--primary-color);
            color: white;
        }

        .btn:hover {
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 10px;
            }

            .cart-button {
                width: 140px;
                height: 50px;
                font-size: 1em;
                bottom: 20px;
                right: 20px;
            }

            .checkbox-group {
                gap: 10px;
            }

            .checkbox-label {
                padding: 6px 12px;
                font-size: 0.9em;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <div class="container-modal">
        <button type="button" class="cart-button" onclick="toggleModal()">
            <i class="fa-solid fa-cart-shopping"></i> Carrito (<span id="cart-count">0</span>)
        </button>

        <div class="modal" id="cartModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Carrito de Compras</h2>
                    <button class="close-button" onclick="toggleModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="menuForm" method="POST" action="menus.php">
                        <div class="form-group-button">
                            <button type="submit" class="btn btn-primary">Crear Menu</button>
                            <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
                        </div>
                        <div class="form-group">
                            <label for="nombre_menu" class="form-label">Nombre del Menu</label>
                            <textarea class="form-control" id="nombre_menu" name="nombre_menu" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Días</label>
                            <input type="hidden" name="dias" id="dias">
                            <div class="checkbox-group">
                                <?php
                                    $dias_semana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
                                    foreach ($dias_semana as $dia) {
                                        echo "<label class='checkbox-label'>
                                                <input type='checkbox' class='checkbox-input dia' id='dia_$dia' value='$dia'>
                                                " . ucfirst($dia) . "
                                            </label>";
                                    }
                                ?>
                            </div>
                        </div>
                        <input type="hidden" name="productos" id="productos">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Productos</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" style="text-align: right; font-weight: bold;">Total:</td>
                                    <td id="total-pedidos" style="font-weight: bold;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('cartModal');
            modal.classList.toggle('show');
        }
    </script>
    <script>
        let listaProductos = [];
        let selectedDays = [];
                                            
        // Cargar productos y días desde localStorage al iniciar
        function cargarProductos() {
            const productosGuardados = localStorage.getItem('carrito');
            if (productosGuardados) {
                listaProductos = JSON.parse(productosGuardados);
            }
            const diasGuardados = localStorage.getItem('selectedDays');
            if (diasGuardados) {
                selectedDays = JSON.parse(diasGuardados);
                // Actualizar los checkboxes según los días guardados
                document.querySelectorAll('.dia').forEach(checkbox => {
                    checkbox.checked = selectedDays.includes(checkbox.value);
                });
            }
            actualizarCarrito();
        }
    
        // Guardar productos y días en localStorage
        function guardarProductos() {
            localStorage.setItem('carrito', JSON.stringify(listaProductos));
            localStorage.setItem('selectedDays', JSON.stringify(selectedDays));
        }
    
        // Actualizar los días seleccionados
        function actualizarDias() {
            selectedDays = [];
            document.querySelectorAll('.dia:checked').forEach(checkbox => {
                selectedDays.push(checkbox.value);
            });
            guardarProductos();
        }
    
        function agregarProducto(id_producto, nombre_prod, precio) {
            const productoExistente = listaProductos.find(p => p.id_producto === id_producto);
            if (productoExistente) {
                productoExistente.cantidad += 1;
            } else {
                listaProductos.push({ id_producto, nombre_prod, precio, cantidad: 1 });
            }
            guardarProductos();
            actualizarCarrito();
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
                selectedDays = [];
                document.querySelectorAll('.dia').forEach(checkbox => {
                    checkbox.checked = false;
                });
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
            cartCount.textContent = listaProductos.reduce((sum, p) => sum + p.cantidad, 0);
        }
    
        // Actualizar el campo oculto de días y productos al enviar el formulario
        document.getElementById('menuForm').addEventListener('submit', function(e) {
            actualizarDias();
            document.getElementById('productos').value = JSON.stringify(listaProductos);
            document.getElementById('dias').value = JSON.stringify(selectedDays);
        });
    
        // Escuchar cambios en los checkboxes de días
        document.querySelectorAll('.dia').forEach(checkbox => {
            checkbox.addEventListener('change', actualizarDias);
        });
    
        // Cargar productos y días al iniciar la página
        window.addEventListener('load', cargarProductos);
    </script>