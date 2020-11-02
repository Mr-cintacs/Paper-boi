
<?php 


ini_set('max_execution_time', 300);
include 'vendor/autoload.php';
require_once('fpdf/fpdf.php');
include('database.php');
use \setasign\Fpdi\Fpdi;

$get_arr = $_GET['page'];
$file_name = $_GET['file_name'];
//FILE NAME FORMAT = QP-Month-year-converted.pdf
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile("import_files/$file_name");
//$pdf->setSourceFile("test_files/QP-May-2018-converted.pdf");

foreach($get_arr as $key=>$page_no)
{
	$tplIdx = $pdf->importPage($page_no);
	$page_width = $pdf->GetPageWidth();
	$pdf->useImportedPage($tplIdx, 10, 10, 200);
	$pdf->AddPage();
 }   

//$page_no=1;
// $tplIdx = $pdf->importPage($page_no);
// $page_width = $pdf->GetPageWidth();
// $pdf->useImportedPage($tplIdx, 10, 10, 200);
// $pdf->AddPage();

//$pdf->AddPage();
// $pdf->SetFont('Helvetica');
// $pdf->SetTextColor(0, 0, 0);
// $pdf->SetXY(30, 30);
// $pdf->Write(0, 'Tum logone ne ab bhi back lani hai');

$pdf->Output();   


 ?>
