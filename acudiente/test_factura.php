<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    require_once('../libraries/TCPDF/tcpdf.php');
    
    $conex = new Database;
    $con = $conex->conectar();

    // ID de pedido de prueba (cambiar por uno que exista en tu base de datos)
    $id_pedido = 20; // Usar un ID que exista en tu tabla pedidos

    // Verificar si el pedido existe
    $query_pedido = "SELECT p.*, u.nombre, u.apellido, u.email, u.telefono, 
                    e.nombre_escuela, e.email_esc, e.telefono_esc,
                    mp.metodo as metodo_pago
                    FROM pedidos p
                    JOIN usuarios u ON p.documento = u.documento
                    JOIN detalles_usuarios_escuela due ON u.documento = due.documento
                    JOIN escuelas e ON due.id_escuela = e.id_escuela
                    JOIN metodos_pago mp ON p.id_met_pago = mp.id_met_pago
                    WHERE p.id_pedidos = ?";
    $stmt_pedido = $con->prepare($query_pedido);
    $stmt_pedido->execute([$id_pedido]);
    $pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        die('Pedido no encontrado. Verifica que el ID ' . $id_pedido . ' exista en la tabla pedidos.');
    }

    // Consulta para obtener los detalles del pedido
    $query_detalles = "SELECT dpp.*, p.nombre_prod, p.precio as precio_unitario, 
                      m.nombre_menu, m.precio as precio_menu
                      FROM detalles_pedidos_producto dpp
                      JOIN producto p ON dpp.id_producto = p.id_producto
                      JOIN menus m ON dpp.id_menu = m.id_menu
                      WHERE dpp.id_pedido = ?";
    $stmt_detalles = $con->prepare($query_detalles);
    $stmt_detalles->execute([$id_pedido]);
    $detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

    // Crear el PDF
    class MYPDF extends TCPDF {
        // Cabecera de página
        public function Header() {
            // Título
            $this->SetFont('helvetica', 'B', 18);
            $this->Cell(0, 15, 'FACTURA DE VENTA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);

            // Información de la empresa
            $this->SetFont('helvetica', '', 9);
            $this->Cell(0, 0, 'NUTRIKIDS - Alimentación Escolar Saludable', 0, 1, 'C');
            $this->Cell(0, 0, 'Teléfono: +57 122 132 2334 | Email: nutrikids.fj@gmail.com', 0, 1, 'C');
            $this->Cell(0, 0, 'Bogotá D.C., Colombia', 0, 1, 'C');

            // Línea separadora
            $this->Line(10, 40, 200, 40);
            $this->Ln(10);
        }

        // Pie de página
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    // Crear nuevo documento PDF
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Configurar documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NutriKids');
    $pdf->SetTitle('Factura #' . $id_pedido);
    $pdf->SetSubject('Factura de Pedido');
    $pdf->SetKeywords('Factura, NutriKids, Pedido');

    // Establecer márgenes
    $pdf->SetMargins(10, 45, 10);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Añadir página
    $pdf->AddPage();

    // Información del cliente y factura
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(90, 0, 'Factura #: ' . $id_pedido, 0, 0, 'L');
    $pdf->Cell(90, 0, 'Fecha: ' . date('d/m/Y', strtotime($pedido['fecha_ini'])), 0, 1, 'R');
    $pdf->Cell(90, 0, 'Escuela: ' . $pedido['nombre_escuela'], 0, 0, 'L');
    $pdf->Cell(90, 0, 'Teléfono escuela: ' . $pedido['telefono_esc'], 0, 1, 'R');
    $pdf->Cell(90, 0, 'Cliente: ' . $pedido['nombre'] . ' ' . $pedido['apellido'], 0, 0, 'L');
    $pdf->Cell(90, 0, 'Email: ' . $pedido['email'], 0, 1, 'R');
    $pdf->Cell(90, 0, 'Teléfono: ' . $pedido['telefono'], 0, 0, 'L');
    $pdf->Cell(90, 0, 'Método de pago: ' . $pedido['metodo_pago'], 0, 1, 'R');
    $pdf->Ln(10);

    // Encabezado de la tabla de productos
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(100, 7, 'Producto / Menú', 1, 0, 'L', 1);
    $pdf->Cell(30, 7, 'Precio Unit.', 1, 0, 'R', 1);
    $pdf->Cell(20, 7, 'Cantidad', 1, 0, 'C', 1);
    $pdf->Cell(40, 7, 'Subtotal', 1, 1, 'R', 1);

    // Detalles de los productos
    $pdf->SetFont('helvetica', '', 9);
    $fill = false;
    foreach ($detalles as $detalle) {
        $pdf->Cell(100, 7, $detalle['nombre_prod'] . ' (' . $detalle['nombre_menu'] . ')', 1, 0, 'L', $fill);
        $pdf->Cell(30, 7, '$' . number_format($detalle['precio_unitario'], 1, '.', ''), 1, 0, 'R', $fill);
        $pdf->Cell(20, 7, $detalle['cantidad'], 1, 0, 'C', $fill);
        $pdf->Cell(40, 7, '$' . number_format($detalle['subtotal'], 1, '.', ''), 1, 1, 'R', $fill);
        $fill = !$fill;
    }

    // Total del pedido
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(150, 7, 'TOTAL:', 1, 0, 'R', 1);
    $pdf->Cell(40, 7, '$' . number_format($pedido['total_pedido'], 1, '.', ''), 1, 1, 'R', 1);
    $pdf->Ln(10);

    // Información adicional
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 0, 'Días de entrega: ' . str_replace(',', ', ', $pedido['dia']), 0, 'L');
    $pdf->MultiCell(0, 0, 'Fecha de inicio: ' . date('d/m/Y', strtotime($pedido['fecha_ini'])), 0, 'L');
    $pdf->MultiCell(0, 0, 'Fecha de finalización: ' . date('d/m/Y', strtotime($pedido['fecha_fin'])), 0, 'L');
    $pdf->Ln(10);

    // Mensaje de agradecimiento
    $pdf->SetFont('helvetica', 'I', 10);
    $pdf->MultiCell(0, 0, 'Gracias por su compra. Para cualquier consulta sobre este pedido, por favor contacte a nuestra escuela o al equipo de NutriKids.', 0, 'C');

    // Generar nombre del archivo
    $nombre_archivo = 'factura_nutrikids_' . $id_pedido . '_' . date('Y-m-d_H-i-s') . '.pdf';
    $ruta_archivo = '../PDF/' . $nombre_archivo;

    // Guardar el PDF en la carpeta PDF
    $pdf->Output($ruta_archivo, 'F');

    // Actualizar la base de datos con el nombre del archivo
    $query_update = "UPDATE pedidos SET archivo = ? WHERE id_pedidos = ?";
    $stmt_update = $con->prepare($query_update);
    $stmt_update->execute([$nombre_archivo, $id_pedido]);

    echo "<h2>✅ Factura generada exitosamente</h2>";
    echo "<p><strong>Archivo:</strong> " . $nombre_archivo . "</p>";
    echo "<p><strong>Ruta:</strong> " . $ruta_archivo . "</p>";
    echo "<p><strong>ID Pedido:</strong> " . $id_pedido . "</p>";
    echo "<p><a href='../PDF/" . $nombre_archivo . "' target='_blank'>Ver PDF</a></p>";
    echo "<p><a href='asignacion.php'>Volver a asignación</a></p>";
?> 