<?php
require "../Database/database.php";

require "../fpdf/fpdf.php";

$stuid = $_GET["stuid"];
$requestid = $_GET["requestid"];
$pdf = new FPDF();

$query = "SELECT * FROM request WHERE stuid=$stuid AND requestid=$requestid ORDER BY request_date DESC";

$res = $conn->query($query);

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 10, "REQUESTION LETTER", 0, 1, 'C');
        $pdf->Ln(10);


        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, "From,");
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, "\t\t\t\t\t\t\t\t\t" . $row["fromname"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["collegename"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["city"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["zipcode"] . ".", 0, 1);

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(0, 10, "To,");
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, "\t\t\t\t\t\t\t\t\t" . $row["toname"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["collegename"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["city"] . ",\n\t\t\t\t\t\t\t\t\t" . $row["zipcode"] . ".", 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Subject: " . $row["subjects"] . "", 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 12);

        $pdf->MultiCell(0, 10, "Respected Sir/Madam,\n\t\t\t\t\t\t\t\t\t\tI am " . $row["fromname"] . ", a student of Master of computer application, in your esteemed institution. I require a " . $row["subjects"] . ". Kindly issue the certificate at your earliest convenience.", 0, 'L');
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Thanking You.', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Yours Obediently,', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, '' . $row["fromname"] . ',', 0, 1, 'R');
        $pdf->Ln(5);
        $pdf->Cell(190, 10, 'Date : ' . $row["request_date"] . '', 0, 1, 'L');
        $pdf->Cell(190, 10, 'Place : ' . $row["city"] . '', 0, 1, 'L');
    }
}
$pdf->Output();
