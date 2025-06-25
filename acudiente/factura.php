<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    require_once('../libraries/TCPDF/vendor/tecnickcom/tcpdf/tcpdf.php');
    
    $conex =new Database;
    $con = $conex->conectar();

    // Obtener el ID del pedido desde la URL
    $id_pedido = isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 0;

    if ($id_pedido <= 0) {
        die('ID de pedido no válido');
    }

    // Consulta para obtener los datos del pedido
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
        die('Pedido no encontrado');
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

    // Consulta para obtener los detalles del menu
    $query_detalles_menu = "SELECT dpm.*, m.nombre_menu, m.precio, DISTINCT dm.dias as dias_menu
    FROM detalles_pedidos_menu dpm
    JOIN menus m ON dpm.id_menu = m.id_menu
    JOIN detalles_menu dm ON dpm.id_menu = dm.id_menu
    WHERE dpm.id_pedido = ?";
    $stmt_detalles_menu = $con->prepare($query_detalles_menu);
    $stmt_detalles_menu->execute([$detalles['id_menu']]);
    $detalles_menu = $stmt_detalles_menu->fetchAll(PDO::FETCH_ASSOC);

    // Crear el PDF
    class MYPDF extends TCPDF {
        // Cabecera de página
        public function Header() {
            // Logo
            // $image_file = '../img/logo-nutrikids2.png';
            // $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

            // Título
            $this->SetFont('helvetica', 'B', 18);
            $this->Cell(0, 15, 'FACTURA DE VENTA', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->Ln(10);

            // Información de la empresa
            $this->SetFont('helvetica', '', 9);
            $this->Cell(0, 0, 'NUTRIKIDS - Alimentación Escolar Saludable', 0, 1, 'C');
            $this->Cell(0, 0, 'Teléfono: +57 122 132 2334 | Email: nutrikids.fj@gmail.com', 0, 1, 'C');
            $this->Cell(0, 0, 'Ibagué, Colombia', 0, 1, 'C');

            // Línea separadora
            $this->Line(10, 40, 200, 40);
            $this->Ln(10);
        }

        // Pie de página
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0,    false, 'T', 'M');
        }
    }

    // Crear nuevo documento PDF
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Configurar documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NUTRIKIDS');
    $pdf->SetTitle('Factura #' . $id_pedido);
    $pdf->SetSubject('Factura de Pedido');
    $pdf->SetKeywords('Factura, NUTRIKIDS, Pedido');

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
    $pdf->Cell(40, 7, '$' . number_format($pedido['total_pedido']), 1, 1, 'R', 1);
    $pdf->Ln(10);

    // Información adicional
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 0, 'Días de entrega: ' . str_replace(',', ', ', $detalles_menu['dias_menu']), 0, 'L');
    $pdf->MultiCell(0, 0, 'Fecha de inicio: ' . date('d/m/Y', strtotime($pedido['fecha_ini'])), 0, 'L');
    $pdf->MultiCell(0, 0, 'Fecha de finalización: ' . date('d/m/Y', strtotime($pedido['fecha_fin'])), 0, 'L');
    $pdf->Ln(10);

    // Mensaje de agradecimiento
    $pdf->SetFont('helvetica', 'I', 10);
    $pdf->MultiCell(0, 0, 'Gracias por su compra. Para cualquier consulta sobre este pedido, por favor contacte a nuestra escuela o al equipo de NUTRIKIDS.', 0, 'C');

    // Generar nombre del archivo
    $nombre_archivo = 'factura_nutrikids_' . $id_pedido . '_' . date('Y-m-d_H-i-s') . '.pdf';
    
    // Obtener la ruta absoluta del directorio PDF
    $ruta_absoluta = dirname(__FILE__) . '/../PDF/';
    $ruta_archivo = $ruta_absoluta . $nombre_archivo;

    // Verificar que el directorio PDF existe, si no, crearlo
    if (!is_dir($ruta_absoluta)) {
        mkdir($ruta_absoluta, 0755, true);
    }

    // Actualizar la base de datos con el nombre del archivo
    $query_update = "UPDATE pedidos SET archivo = ? WHERE id_pedidos = ?";
    $stmt_update = $con->prepare($query_update);
    $stmt_update->execute([$nombre_archivo, $id_pedido]);

    // Guardar el PDF en la carpeta PDF y mostrarlo en el navegador
    $pdf->Output($ruta_archivo, 'FI');
?>