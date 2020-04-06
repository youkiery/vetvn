<?php
// // require_once('/vendor/autoload.php');

// $template_file_name = 'template-1.docx';
 
// $rand_no = rand(111111, 999999);
// $fileName = "results_" . $rand_no . ".docx";
 
// $folder   = "results_";
// $full_path = $folder . '/' . $fileName;
 
// try {
//   if (!file_exists($folder)) {
//     mkdir($folder);
//   }       
         
//   copy($template_file_name, $full_path);
//   $zip_val = new ZipArchive;

//   if($zip_val->open($full_path) == true) {
//     $key_file_name = 'word/document.xml';
//     $message = $zip_val->getFromName($key_file_name);                
//     $timestamp = date('d-M-Y H:i:s');
//     $message = str_replace("form-code", "VA-55", $message);
//     var_dump($message);
//     die();
//     $zip_val->addFromString($key_file_name, $message);
//     $zip_val->close();
//   }

//     // define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);
    
//     // require_once DOC_ROOT . '/vendor/phpoffice/phpword/bootstrap.php';
//     // require 'vendor/autoload.php';
    
//     // use Dompdf\Dompdf;
//     // $report_file_doc = DOC_ROOT . '/form-1.docx';
//     // $report_file_pdf = DOC_ROOT . '/form-1.pdf';

//     // PhpOffice\PhpWord\Settings::setPdfRendererName(PhpOffice\PhpWord\Settings::PDF_RENDERER_DOMPDF);
//     // PhpOffice\PhpWord\Settings::setPdfRendererPath('.');

//     // $phpWord = PhpOffice\PhpWord\IOFactory::load($report_file_doc, 'Word2007');
//     // $phpWord->save($report_file_pdf, 'PDF');

//     // $dompdf->set_option('isHtml5ParserEnabled', true);
// }
// catch (Exception $exc) {
//   $error_message =  "Error creating the Word Document";
//   var_dump($exc);
// }
