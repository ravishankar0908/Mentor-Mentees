<?php
require('../fpdf/fpdf.php');
require("../Database/database.php");

class PDF extends FPDF
{
    // Header
    function Header()
    {
    }

    // Footer
    function Footer()
    {
    }
}

$menid = $_GET["menid"];

$res = $conn->query("SELECT * FROM mentor WHERE menid=$menid");
if ($res->num_rows) {
    $data = $res->fetch_assoc();
    $mentor_name = $data["fname"];
}



$pdf = new PDF();
$pdf->AddPage('P', 'A4');

$pdf->Image('../Assets/images/hicet-header.jpg', 0, 1, 240, 40, 'JPG');
$pdf->Cell(0, 30, "", 'B', 1);
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(80);
$pdf->Cell(30, 10, 'MENTEES LIST', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Date : ' . date("d-m-Y") . '', 0, 0, 'L');
$pdf->Cell(0, 10, 'Mentor Name : Mrs/Mr.' . $mentor_name . '', 0, 1, 'R');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 's.no', 1);
$pdf->Cell(30, 10, 'Reg. Number', 1);
$pdf->Cell(40, 10, 'Student Name', 1);

$pdf->Cell(10, 10, '', 1);
$pdf->Cell(10, 10, '', 1);
$pdf->Cell(10, 10, '', 1);
$pdf->Cell(10, 10, '', 1);
$pdf->Cell(10, 10, '', 1);
$pdf->Cell(10, 10, '', 1);

$pdf->Cell(45, 10, 'Signature', 1, '', 'C');
$pdf->Ln();


$query = "SELECT * FROM mentormenteeslist INNER JOIN students ON students.stuid=mentormenteeslist.stuid WHERE mentormenteeslist.menid=$menid ORDER BY fname";

$res = $conn->query($query);
$sno = 0;
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $sno++;

        $email = $row["email"];
        $rollno = strstr($email, '@', true);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 10, $sno, 1);
        $pdf->Cell(30, 10, $rollno, 1);
        $pdf->Cell(40, 10, $row['fname'] . " " . $row["lname"], 1);
        $pdf->Cell(10, 10, '', 1);
        $pdf->Cell(10, 10, '', 1);
        $pdf->Cell(10, 10, '', 1);
        $pdf->Cell(10, 10, '', 1);
        $pdf->Cell(10, 10, '', 1);
        $pdf->Cell(10, 10, '', 1);

        $pdf->Cell(45, 10, '', 1);
        $pdf->Ln();
    }
}

$pdf->Output();
