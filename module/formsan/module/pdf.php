<?php

class Formsan_Module_Pdf extends Module_Abstract {

    function execute() {


        try {
            //////////////////////
            $pdf = new Zend_Pdf();
            $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


            $page1 = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
            $page1->setFont($font, 36);
            $x = 88;
            $y = 200;
            $page1->drawText('Some text3...', $x, $y);

            $pdf->pages[] = $page1;
$pdf->save('test-create.pdf');

//odtad nie dziala
            $page2 = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

            $page2//->setStyle($h3)
                    ->drawLine(73, 244, 512, 244)   // HEAD Bottom
                    ->drawLine(73, 244, 73, 166)    // MOST Left
                    ->drawLine(512, 244, 512, 166)  // MOST Right
                    ->drawLine(73, 166, 512, 166)       // MOST Bottom
                    ->drawLine(225, 244, 225, 166)      // MOST Left
//->setStyle($h2)
                    ->drawText('Analytics Site', 73, 252)   // Table Headers
//->setStyle($h3)
                    ->drawText('Page Views', 80, 225)           // Table Headers (402) - 27
                    ->drawText('Bounce Rate', 80, 200)      // Table Headers
                    ->drawText('Avg. Time On Site', 80, 174)    // Table Headers
                    ->drawLine(73, 192, 512, 192)   // Bottom
                    ->drawLine(73, 218, 512, 218);   // Bottom
//->drawText($site_metrics[0]->{"ga:pageviews"}, 235, 225)
//->drawText(sprintf('%1.02f%%', $site_metrics[0]->{"ga:visitBounceRate"}), 235, 200)
//->drawText($avg_time, 235, 174);

            $pdf->pages[] = $page2;

            $pdf->save('test-create.pdf');
        } catch (Exception $e) {
            echo $e->getMessage();
        }

//////////////////


        $this->out['file'] = '/test-create.pdf';


        $this->template = 'formsan/view/pdf.phtml';
        parent::execute();
    }

}
