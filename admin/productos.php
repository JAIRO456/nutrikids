<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- <script src="../JsBarcode/jsbarcode.all.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode/dist/JsBarcode.all.min.js"></script>
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Produtos</h2>
                    <a href="produtos/crear_produtos.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Registrar Produto</a>
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>CODE</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
    <script>
        function getProdutos() {
            fetch('../ajax/get_products.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('table-body');
                    tableBody.innerHTML = '';

                    data.forEach(product => {
                        const barcodeId = `barcode-${product.id_producto}`;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td><svg id="${barcodeId}"></svg></td>
                            <td>${product.nombre_prod}</td>
                            <td>${product.categoria}</td>
                            <td>${product.precio}</td>
                            <td>
                                <a href="produtos/update_producto.php?id=${product.id_producto}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                <a href="produtos/delete_producto.php?id=${product.id_producto}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            </td>
                        `;
                        tableBody.appendChild(row);

                        JsBarcode(`#${barcodeId}`, product.id_producto, {
                            format: "CODE128",
                            width: 2,
                            height: 40,
                            displayValue: true,
                        });
                    });
                })
                .catch(error => console.error('Error al obtener los produtos:', error));
        }
        setInterval(function () {
            getProdutos();
        }, 5000);
    </script>
</html>