<?php
ini_set("display_errors", 1);
error_reporting(255);
//////////////////////
/*$pdf1 = new Zend_Pdf();
$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


$page1 = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
$page1->setFont($font, 36);
$x = 88;
$y = 200;
$page1->drawText('Some text...', $x, $y);

$pdf->pages[] = $page1;


$pdf->save('/test-create.pdf');*/
//////////////////


define('ROOT_PATH', 'c:/wamp/www/cedrus/');
define('ENVIRONMENT', 'dev');
include_once ROOT_PATH . 'manager/controller.php';
Manager_Controller::getInstance()->run();