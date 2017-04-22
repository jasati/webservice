<?php
header("Access-Control-Allow-Credentials: false");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Content-Type: application/pdf'); 
header('Content-Description: inline; filename.pdf');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
   header( "HTTP/1.1 200 OK" );
   exit();
}
define('DS',DIRECTORY_SEPARATOR);
require 'Library'.DS.'MPDF'.DS.'mpdf.php';

$mpdf = new mPDF;
$html = '<h1> Relatorios Jasati </h1><p> Aqui mostrará seus relatórios</p>';
$mpdf->WriteHTML($html);
$name = time().'.pdf';
$mpdf->Output($name,'F');
echo json_encode(array( 'report_name' => $name));
