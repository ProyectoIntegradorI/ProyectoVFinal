<?php
require('fpdf.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedRows = $_POST['selectedRows'] ?? [];

    if (empty($selectedRows)) {
        die('No se seleccionó ninguna evaluación.');
    }

    // Crear un nuevo PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Ruta de la imagen
    $imagePath = '../img/aetemeLogo2.jpg';

    // Obtener el ancho de la página y de la imagen
    $pageWidth = $pdf->GetPageWidth();
    $imageWidth = 50; // Ancho deseado para la imagen

    // Calcular la posición X para centrar la imagen
    $x = ($pageWidth - $imageWidth) / 2;

    // Agregar imagen centrada al PDF
    $pdf->Image($imagePath, $x, 10, $imageWidth);

    // Mover el cursor del PDF para evitar que el texto se superponga a la imagen
    $pdf->Ln(40);

    // Establecer fuente para el título
    $pdf->SetFont('Arial', 'B', 16);

    // Título del documento
    $title = "Reporte de Evaluaciones Físicas";
    $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $title), 0, 1, 'C');

    // Espacio después del título
    $pdf->Ln(10);

    // Establecer fuente para el contenido
    $pdf->SetFont('Arial', '', 12);

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "Sanchez18.", "proyectoint1");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    foreach ($selectedRows as $evalId) {
        $sql = "SELECT evalId, userId, admiId, IMC, porcentGras, aguaCorp, pesoEnMusc, nivProt, fecha, observa FROM evalFis WHERE evalId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $evalId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Imprimir datos en el PDF hacia abajo
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Id Evaluacion: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['evalId']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Id Atleta: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['userId']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Id Administrador: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['admiId']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'IMC: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['IMC']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Porcentaje Grasa: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['porcentGras']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Agua Corporal: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['aguaCorp']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Peso en Musculo: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['pesoEnMusc']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Nivel de Proteina: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['nivProt']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Fecha: '), 0);
        $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['fecha']), 0, 1);
        
        $pdf->Cell(50, 10, iconv('UTF-8', 'ISO-8859-1', 'Observaciones: '), 0);
        $pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', $row['observa']), 0);

        // Espacio entre evaluaciones
        $pdf->Ln(10);
    }

    // Salida del PDF
    $pdf->Output('D', 'evaluaciones.pdf');

    // Cerrar conexión
    $conn->close();
} else {
    echo "Método no permitido.";
}


?>