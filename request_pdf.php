<?php
require "./Database/database.php";

require "./fpdf/fpdf.php";
$pdf = new FPDF();

$query = "SELECT * FROM request";

$res = $conn->query($query);

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, "REQUESTION LETTER", 0, 1, 'C');
        $pdf->Ln(10);


        $pdf->SetFont('Arial', '', 12);


        $pdf->MultiCell(0, 10, "From,\n\t\t\t\t\t\t\t\t\t" . $row["fromname"] . ",\n\t\t\t\t\t\t\t\t\t[College Name],\n\t\t\t\t\t\t\t\t\t[College Address],\n\t\t\t\t\t\t\t\t\t[City, State, ZIP Code].", 0, 1);

        $pdf->Ln(5);
        $pdf->MultiCell(0, 10, "To,\n\t\t\t\t\t\t\t\t\t" . $row["toname"] . ",\n\t\t\t\t\t\t\t\t\t[College Name],\n\t\t\t\t\t\t\t\t\t[College Address],\n\t\t\t\t\t\t\t\t\t[City, State, ZIP Code].", 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Subject: Request for Bonafide Certificate', 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 12);

        $pdf->MultiCell(0, 10, "Respected Sir/Madam,\nI am [Your Full Name], a student of [Course Name], [Year/ Semester] in your esteemed institution. I require a bonafide certificate for [mention the purpose, e.g., applying for a passport, internship, scholarship, etc.]. Kindly issue the certificate at your earliest convenience.", 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Thanking You.', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Yours Obediently,', 0, 1, 'R');
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Date : ', 0, 1, 'L');
        $pdf->Cell(190, 10, 'Place : ', 0, 1, 'L');
    }
}
$pdf->Output();
