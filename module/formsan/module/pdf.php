<?php

class Formsan_Module_Pdf extends Module_Abstract {

    function execute() {

    //////////////////////
$pdf = new Zend_Pdf();
$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


$page1 = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
$page1->setFont($font, 36);
$x = 88;
$y = 200;
$page1->drawText('Some text...', $x, $y);

$pdf->pages[] = $page1;

$pdf->save('test-create.pdf');

print_r($pdf);
$pdfString = $pdf->render();

echo $pdfString;

//$pdf->save('/test-create.pdf');

exit;

//////////////////

        
        
        
        exit;
        $this->template = 'formsan/view/pdf.phtml';
        parent::execute();
    }

}
