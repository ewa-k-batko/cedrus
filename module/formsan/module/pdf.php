<?php

class Formsan_Module_Pdf extends Module_Abstract {

    const PDF_FILE_PATH = 'katalog-szkolki-ogrodniczej-mirage.pdf';
    const WIDTH = 600;
    const HEIGHT = 820;
    const MAX_X = 575;
    const MIN_X = 25;
    const MAX_Y = 790;
    const MIN_Y = 50;
    const PAD_W = 12;
    const PAD_H = 12;
    const LINE_HR = 1.2;

    private $cur_X, $cur_Y, $font, $font_H, $pdf, $page, $pos;

    function execute() {

        try {

            $this->api = new Model_Plant_Source_ApiAd(Model_Plant_Source_Factory::DB_MYSQL_AD);
            $list = $this->api->getOfferList();
            //print_r($list); exit;
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $this->out['report'] = 'start generate pdf<br>';
        try {

            $this->pdf = new Zend_Pdf();

            $pdf->properties['Title'] = 'Katalog produktów szkółki ogrodniczej "Mirage"';

            if (Manager_Config::isDev()) {
                $this->font = Zend_Pdf_Font::fontWithPath($_SERVER['DOCUMENT_ROOT'] . 'opensansregular.ttf');
            } else {
                $this->font = Zend_Pdf_Font::fontWithPath('../public/fonts/opensansregular.ttf');
            }

            $this->pdf->pages = array();
            $this->page = $this->getTemplate();
            $this->pos = 0;

            $tmpCat = null;

            if ($list instanceof Model_Collection) {
                foreach ($list as $plant) {

                    $category = $plant->getCategory();

                    if ($tmpCat != $category->getName()) {
                        $this->addCategory($category);
                        $tmpCat = $category->getName();
                    }

                    $pot = $plant->getPot();
                    if ($pot instanceof Model_Plant_Pot_Container) {
                        $pot = (string) $pot->getName();
                    }
                    $this->addPlant($plant, (string) $pot);
                }
            }

            $this->pdf->pages[$this->pos++] = $this->page;


            //koniec dokumentu

            $size = count($this->pdf->pages);

            for ($i = 0; $i < $size; $i++) {
                $strona = 'strona: ' . ($i + 1) . ' z ' . $size;
                $this->pdf->pages[$i]->drawText($strona, self::MAX_X - 65, self::MAX_Y + 35, 'UTF-8');
            }


            $this->out['report'] = 'stron: ' . $size . ' pdf<br>';

            $fileName = str_replace('.pdf', date('ymd') . '.pdf', self::PDF_FILE_PATH);

            if (Manager_Config::isDev()) {
                $fileName = $fileName;
            } else {
                $fileName = '../public/' . $fileName;
            }

            $this->pdf->save($fileName, true);

            $this->out['report'] .= 'koniec generate pdf<br>';
        } catch (Exception $e) {
            $this->out['error'] = $e->getMessage() . '<br>';

            //echo $e->getMessage();
        }


        $this->out['file'] = $fileName;

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
        
        //logo
        $image = Zend_Pdf_Image::imageWithPath($_SERVER['DOCUMENT_ROOT'] .'/img/s-logo-mirage-pdf.png'); 
 
        // Draw image 
        $page->drawImage($image, self::MIN_X, $y-10, self::MIN_X+102, $y + 40-10); 
        
        
        
        $page->drawText('Katalog szkółki ogrodniczej "MIRAGE"', self::MIN_X + 130, $y, 'UTF-8');
        $y = $this->setNPT_Y();
        $page->drawLine(self::MIN_X, $y, self::MAX_X, $y);

       // $this->cur_Y = self::MAX_Y - self::PAD_H;

        /* FOOTER */
        $style = $this->getFootStyle();
        $page->setStyle($style);
        $y = self::PAD_H + self::PAD_H;
        $page->drawText('Szkółka ogrodnicza "Mirage", www: sadzonka.eu, adres: Pawlikowice 182, 32-020-Wieliczka, tel: 519431929, 506455392', self::MIN_X, self::PAD_H, 'UTF-8')
                ->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        return $page;
    }

    private function addPlant($plant, $pot) {


        //dzieli opis na linie
        $lines = $this->calcPlantDescLine($plant->getDescription());

        //spr. czy plant zmiesci sie na obecnej stronie , jelsi nie tworzy nowa 
        if (!$this->checkPlantPlace($lines['size'])) {
            $this->pdf->pages[$this->pos++] = $this->page;
            $this->page = $this->getTemplate();
        }


        $style = $this->getPlantStyle();
        $this->page->setStyle($style);

        $y = $this->setNPT_Y();

        //nazwa
        $this->page->drawText($plant->getName() . ' "' . $plant->getSpecies() . '" (' . $plant->getIsnNo() . ')', self::MIN_X, $y, 'UTF-8');
        $style->setFontSize($style->getFontSize() + 1);
        $this->page->setStyle($style);

        //cena
        $this->page->drawText($plant->getPrice() . ' zł', self::MAX_X - 40, $y, 'UTF-8');


        $style->setFontSize($style->getFontSize() - 2);
        $this->page->setStyle($style);

        //opis
        for ($i = 0; $i < $lines['size']; $i++) {
            $y = $this->setNST_Y();
            $this->page->drawText($lines['lines'][$i], self::MIN_X, $y, 'UTF-8');
        }

        $y = $this->setNST_Y();

        //wysokosc + doniczka
        $this->page->drawText('Wysokość sadzonki: ' . $plant->getHeight() . ' cm, doniczka: ' . $pot, self::MIN_X, $y, 'UTF-8');
        $y = $this->setNST_Y();

        //linia    
        $this->page->drawLine(self::MIN_X, $y, self::MAX_X, $y);
    }

    private function addCategory($category) {
        $this->setNPT_Y();

        if (!$this->checkCategoryPlace()) {
            $this->pdf->pages[$this->pos++] = $this->page;
            $this->page = $this->getTemplate();
        }

        $style = $this->getCategoryStyle();
        $this->page->setStyle($style);

        $y = $this->setNPT_Y();

        $this->page->drawText($category->getName(), self::MIN_X, $y, 'UTF-8');
        $y = $this->setNPT_Y();
        $this->page->drawLine(self::MIN_X, $y, self::MAX_X, $y);
    }

    private function getFootStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#330000'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 10;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getHeadStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#339933'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 18;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getCategoryStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#cc0066'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 14;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getPlantStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#330000'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
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

    private function checkSizeY() {
        return $this->cur_Y - self::MIN_Y;
    }

    private function checkCategorySizeY() {
        return (self::PAD_H * self::LINE_HR * 2);
    }

    private function calcPlantDescLine($desc) {
        $signs = 110;
        $desc = wordwrap($desc, $signs, "\n");
        $lines = explode("\n", $desc);
        return array('size' => count($lines), 'lines' => $lines);
    }

    private function checkPlantSizeY($lines) {

        $tmp = (self::PAD_H * self::LINE_HR * 2 ) + ( self::PAD_H * self::LINE_HR * $lines);
        return $tmp;
    }

    private function checkPlantPlace($lines) {

        // var_dump($this->checkSizeY());
        //var_dump($this->checkPlantSizeY($lines));
        // var_dump($this->checkSizeY() - $this->checkPlantSizeY($lines)); //exit;
        return ($this->checkSizeY() - $this->checkPlantSizeY($lines)) <= 0 ? false : true;
    }

    private function checkCategoryPlace() {

        //var_dump($this->checkSizeY());
        // var_dump($this->checkCategorySizeY());
        //var_dump($this->checkSizeY() - $this->checkCategorySizeY()); //exit;
        return ($this->checkSizeY() - $this->checkCategorySizeY()) <= 0 ? false : true;
    }

}
