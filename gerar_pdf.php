<?php
require 'connection.php';
require 'vendor/fpdf/fpdf.php';

// Recebe o filtro
$filtro = isset($_GET['filtro']) ? intval($_GET['filtro']) : null;

// Consulta SQL
$sql = "SELECT f.id_funcionario, f.nome_funcionario, f.cpf, f.email, d.nome_departamento 
        FROM funcionarios f 
        JOIN departamento d ON f.id_departamento = d.id_departamento";

if ($filtro) {
    $sql .= " WHERE f.id_departamento = $filtro";
}

$result = $conn->query($sql);
$total_funcionarios = $result->num_rows;

// Criar PDF com margens reduzidas
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Cabeçalho com logo
$pdf->Image('/opt/lampp/htdocs/Html/AtvBootstrap/gragasgame1.png', 15, 10, 30);
$pdf->Cell(0, 10, 'Relatorio de Funcionarios', 0, 1, 'C');
$pdf->Ln(10);

// Configurar tabela
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 220, 255);

// Cabeçalhos da tabela
$pdf->Cell(15, 7, 'ID', 1, 0, 'C', true);
$pdf->Cell(70, 7, 'Nome', 1, 0, 'C', true);
$pdf->Cell(35, 7, 'CPF', 1, 0, 'C', true);
$pdf->Cell(80, 7, 'Email', 1, 0, 'C', true);
$pdf->Cell(60, 7, 'Departamento', 1, 1, 'C', true);

// Dados
$pdf->SetFont('Arial', '', 10);
$altura_linha = 6;

while ($row = $result->fetch_assoc()) {
    if ($pdf->GetY() > 180) {
        $pdf->AddPage('L');
        $pdf->SetY(20);
    }
    
    $cpf_formatado = '***.' . substr($row['cpf'], 3, 3) . '.***-**';
    
    $pdf->Cell(15, $altura_linha, $row['id_funcionario'], 1, 0, 'C');
    $pdf->Cell(70, $altura_linha, utf8_decode($row['nome_funcionario']), 1);
    $pdf->Cell(35, $altura_linha, $cpf_formatado, 1, 0, 'C');
    $pdf->Cell(80, $altura_linha, utf8_decode($row['email']), 1);
    $pdf->Cell(60, $altura_linha, utf8_decode($row['nome_departamento']), 1, 1);
}

// Linha de totalização
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 220, 220); 
$pdf->Cell(15, $altura_linha, '', 1, 0, 'C', true);
$pdf->Cell(70, $altura_linha, 'Total de Funcionarios:', 1, 0, 'R', true);
$pdf->Cell(35, $altura_linha, '', 1, 0, 'C', true);
$pdf->Cell(80, $altura_linha, '', 1, 0, 'C', true);
$pdf->Cell(60, $altura_linha, $total_funcionarios, 1, 1, 'C', true);

// Rodapé
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Gerado em ' . date('d/m/Y H:i:s'), 0, 0, 'C');

// Saída
$pdf->Output('relatorio_funcionarios.pdf', 'D');

$conn->close();
?>
