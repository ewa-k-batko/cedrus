<?php

class Formsan_Module_Pdf extends Module_Abstract {

    const PDF_FILE_PATH = 'katalog.pdf';
    const WIDTH = 600;
    const HEIGHT = 820;
    const MAX_X = 575;
    const MIN_X = 25;
    const MAX_Y = 790;
    const MIN_Y = 50;
    const PAD_W = 12;
    const PAD_H = 12;
    const LINE_HR = 1.2;

    private $cur_X, $cur_Y, $font, $font_H;

    function execute() {
        
      try {

        $this->api = new Model_Plant_Source_ApiAd(Model_Plant_Source_Factory::DB_MYSQL_AD);
        $list = $this->api->getPlantListAd($pack = 1, $sizePack = 20, $sort = Model_Api_Abstract::SORT_NAME, $order = Model_Api_Abstract::ORDER_ASC);
       //print_r($list);
      }catch(Exception $e) {
          echo $e->getMessage();
      }
  

        $this->out['report'] = 'start generate pdf<br>';
        try {
            //////////////////////
            //$pdf = new Zend_Pdf();
            $pdf = Zend_Pdf::load(self::PDF_FILE_PATH);
           // return;
            
            $pdf->properties['Title'] = 'Katalog produktów szkółki ogrodniczej "Mirage"';
            $this->font = Zend_Pdf_Font::fontWithPath($_SERVER['DOCUMENT_ROOT'] . 'opensansregular.ttf');


            //$this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);


            $pdf->pages = array();


            $page1 = $this->getTemplate();
            //$page1 = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
            //$page1->setFont($this->font, 36);

            $this->addCategory($page1, 'Byliny');
            $this->addPlant($page1, 'Abies balsamea "Nana"', 'Odmiana karłowa o pokroju kopulastym, igły krótkie o ciemnozielonej barwie, gęsto osadzone na pędzie.', '20,70 pln');


            foreach ($list as $plant) {


               $this->addPlant($page1, $plant->getName(), $plant->getDescription(), $plant->getPrice());
            }






            $pdf->pages[] = $page1;




//$pdf->save('test-create.pdf');
//odtad nie dziala
            $page2 = $this->getTemplate();
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

            $pdf->pages[1] = $page2;
            $this->out['report'] = 'stron: ' . count($pdf->pages) . ' pdf<br>';
            $pdf->save(self::PDF_FILE_PATH, true);

            $this->out['report'] .= 'koniec generate pdf<br>';
        } catch (Exception $e) {
            $this->out['error'] = $e->getMessage() . '<br>';
        }

//////////////////


        $this->out['file'] = self::PDF_FILE_PATH;


        $this->template = 'Formsan/View/Pdf.phtml';
        parent::execute();
    }

    private function getTemplate() {
        $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);

        $this->cur_Y = self::HEIGHT;

        /* HEADER */
        $y = $this->setNPT_Y();
        $style = $this->getHeadStyle();
        $page->setStyle($style);
        $page->drawText('Katalog szkółki ogrodniczej "MIRAGE"', self::MIN_X, $y, 'UTF-8');
        $y = $this->setNPT_Y();
        $page->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        $this->cur_Y = self::MAX_Y - self::PAD_H;

        /* FOOTER */
        $style = $this->getFootStyle();
        $page->setStyle($style);
        $y = self::PAD_H + self::PAD_H;
        $page->drawText('Copyright (c) ' . date('Y') . ' sadzonka.eu, Szkółka ogrodnicza "Mirage" - Wszelkie prawa zastrzeżone.', self::MIN_X, self::PAD_H, 'UTF-8')
                ->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        return $page;
    }

    private function addPlant($page, $plant, $desc, $prize) {
        $style = $this->getPlantStyle();
        $page->setStyle($style);

        $y = $this->setNPT_Y();

        $page->drawText($plant, self::MIN_X, $y, 'UTF-8');
        $style->setFontSize($style->getFontSize() + 1);
        $page->setStyle($style);

        $page->drawText($prize, self::MAX_X - 70, $y, 'UTF-8');


        $y = $this->setNST_Y();
        //$y = $this->setNPT_Y();

        $style->setFontSize($style->getFontSize() - 2);
        $page->setStyle($style);
        $page->drawText($desc, self::MIN_X, $y, 'UTF-8');

        $y = $this->setNST_Y();
        $page->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        return $page;
    }

    private function addCategory($page, $category) {
        $style = $this->getCategoryStyle();
        $page->setStyle($style);

        $y = $this->setNPT_Y();

        $page->drawText($category, self::MIN_X, $y, 'UTF-8');
        $y = $this->setNPT_Y();
        $page->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        return $page;
    }

    private function getFootStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        // $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(0.1);
        //$style->setLineDashingPattern(array(3, 2, 3, 4), 1.6);

        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        //$this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        //$this->font = Zend_Pdf_Font::fontWithPath(RESOURCES_PATH.DIRECTORY_SEPARATOR.'arial.ttf');c:/wamp/www/istat/fonts/f/
        // echo $_SERVER['DOCUMENT_ROOT'];exit;
        // $this->font = Zend_Pdf_Font::fontWithPath($_SERVER['DOCUMENT_ROOT'].'opensansregular.ttf');
        //$h = fopen($_SERVER['DOCUMENT_ROOT'] . 'op.ttf', 'a+');
        $this->font_H = 10;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getHeadStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        // $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(0.1);
        //$style->setLineDashingPattern(array(3, 2, 3, 4), 1.6);

        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        //$this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $this->font_H = 18;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getCategoryStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        // $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(0.1);
        //$style->setLineDashingPattern(array(3, 2, 3, 4), 1.6);

        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        //$this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $this->font_H = 14;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getPlantStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        // $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        $style->setLineWidth(0.1);
        //$style->setLineDashingPattern(array(3, 2, 3, 4), 1.6);

        $style->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
        //$this->font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $this->font_H = 11;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function setNPT_Y() {
        $this->cur_Y -= self::PAD_H * self::LINE_HR;
        return $this->cur_Y;
    }

    private function setNST_Y() {
        $this->cur_Y -= $this->font_H * self::LINE_HR;
        return $this->cur_Y;
    }

}

/*
 * 
 * public function widthForStringUsingFontSize($string, $font, $fontSize) 
    { 
        $drawingString = iconv('UTF-8', 'UTF-16BE//IGNORE', $string); 
        $characters = array(); 
        for ($i = 0; $i < strlen($drawingString); $i++) { 
            $characters[] = (ord($drawingString[$i++]) << 8) | 
ord($drawingString[$i]); 
        } 
        $glyphs = $font->glyphNumbersForCharacters($characters); 
        $widths = $font->widthsForGlyphs($glyphs); 
        $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * 
$fontSize;       
        return $stringWidth; 

    } 
 * *********************************
 * 
 * 
 * 
 * $this->getResponse()->setHeader('Content-type', 'application/pdf', true);
    $this->getResponse()->setHeader('Content-disposition', 'inline; filename=' . $this->_pdfName . '.pdf', true);
    $this->getResponse()->setBody($pdf->render(false));
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * */