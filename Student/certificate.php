<?php
require "../Database/database.php";

require "../fpdf/fpdf.php";

$reqid = $_GET["reqid"];

$res = $conn->query("SELECT * FROM request WHERE requestid=$reqid");

if ($res->num_rows == 1) {
    $data = $res->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Image('../Assets/images/hicet-header.jpg', 0, 0, 240, 40, 'JPG');
    $pdf->Ln(5);
    $pdf->Cell(0, 30, "", 'B', 1);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, "BONAFIDE CERTIFICATE", '', 1, 'C');
    $pdf->Cell(0, 10, "Date : " . $data["ack_date"] . "", '', 1, 'R');

    if ($data["subjects"] == "Bonafide certificate for passport verfication") {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->MultiCell(0, 10, "\t\t\t\t\t\t\t\t\t\t\t\tThis is to certify " . $data["fromname"] . " is a bonafide student of this instituition and studying " . $data["years"] . " MCA degree course during the academic year 2023-2024. He submitted all his original certifcate in our college.", '', 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "This certificate is issued to apply for " . $data["subjects"] . ".", '', 1, 'C');
    } else if ($data["subjects"] == "Bonafide certficate for applying loan") {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->MultiCell(0, 10, "\t\t\t\t\t\t\t\t\t\t\t\tThis is to certify " . $data["fromname"] . " is a bonafide student of this instituition and studying " . $data["years"] . " MCA degree course during the academic year 2023-2024.", '', 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->Cell(100, 10, "First Semester", '1');
        $pdf->Cell(0, 10, "80,000 rupees", '1', '1');

        $pdf->Cell(100, 10, "Second Semester", '1');
        $pdf->Cell(0, 10, "80,000 rupees", '1', '1');

        $pdf->Cell(100, 10, "Third Semester", '1');
        $pdf->Cell(0, 10, "80,000 rupees", '1', '1');


        $pdf->Cell(100, 10, "Fourth Semester", '1');
        $pdf->Cell(0, 10, "80,000 rupees", '1', '1');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 10, "Total", '1');
        $pdf->Cell(0, 10, "3,20,000 rupees", '1', '1');



        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "This certificate is issued to apply education loan.", '', 1, 'C');
    } else if ($data["subjects"] == "Bonafide certficate for applying Scholarships") {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(5);
        $pdf->MultiCell(0, 10, "\t\t\t\t\t\t\t\t\t\t\t\tThis is to certify " . $data["fromname"] . " is a bonafide student of this instituition and studying " . $data["years"] . " MCA degree course during the academic year 2023-2024.", '', 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, "This certificate is issued to apply for the Scholarship.", '', 1, 'C');
    }
}


$men = $conn->query("SELECT * FROM mentor WHERE designation='HOD'");
if ($men->num_rows == 1) {
    $data = $men->fetch_assoc();
    $pdf->Ln(15);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Head of the Department", '', 1, 'R');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "" . $data["fname"] . "" . $data["lname"] . "", '', 1, 'R');
}

$pdf->Output();
