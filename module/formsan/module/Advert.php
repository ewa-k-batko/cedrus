<?php

class Formsan_Module_Advert extends Module_Abstract {

//'297:420'
    const PDF_FILE_PATH = 'ulotka-informacyjna-szkolki-ogrodniczej-mirage.pdf';
    const WIDTH = 420;
    const HEIGHT = 300;
    const MAX_X = 400;
    const MIN_X = 20;
    const MAX_Y = 290;
    const MIN_Y = 10;
    const PAD_W = 12;
    const PAD_H = 12;
    const LINE_HR = 1.2;

    private $cur_X, $cur_Y, $font, $font_H, $pdf;

    function execute() {

        /* try {

          $this->api = new Model_Plant_Source_ApiAd(Model_Plant_Source_Factory::DB_MYSQL_AD);
          $list = $this->api->getOfferList();
          //print_r($list); exit;
          } catch (Exception $e) {
          echo $e->getMessage();
          } */

        $this->out['report'] = 'start generate ulotka<br>';
        try {

            $this->pdf = new Zend_Pdf();

            $pdf->properties['Title'] = 'Ulotak informacyjna szkółki ogrodniczej "Mirage"';

            if (Manager_Config::isDev()) {
                $this->font = Zend_Pdf_Font::fontWithPath($_SERVER['DOCUMENT_ROOT'] . 'fonts/robotocondensed-regular.ttf');
            } else {
                $this->font = Zend_Pdf_Font::fontWithPath('../public/fonts/robotocondensed-regular.ttf');
            }

            $this->pdf->pages = array();
            $this->page = $this->getFront();
            $this->pdf->pages[] = $this->page;


            //MAPA
            $page = new Zend_Pdf_Page('420:300');

            $style = $this->getOfferStyle();
            $page->setStyle($style);

            
            $y = self::HEIGHT-25;

            $page->drawText('Lokalizacja sklepu "Mirage":', self::MIN_X, $y, 'UTF-8');

            //mapa
            $image = Zend_Pdf_Image::imageWithPath($_SERVER['DOCUMENT_ROOT'] . '/img/ulotka-mapa-s.png');

            // Draw image 
            $page->drawImage($image, self::MIN_X, self::MIN_Y + 15, self::MIN_X + 300, self::MIN_Y + 224 + 15);

            $this->pdf->pages[] = $page;

            //koniec dokumentu

            $fileName = str_replace('.pdf', date('ymd') . '.pdf', self::PDF_FILE_PATH);

            if (Manager_Config::isDev()) {
                $fileName = $fileName;
            } else {
                $fileName = '../public/' . $fileName;
            }

            $this->pdf->save($fileName, true);

            $this->out['report'] .= 'koniec generate ulotka<br>';
        } catch (Exception $e) {
            $this->out['error'] = $e->getMessage() . '<br>';

            //echo $e->getMessage();
        }


        $this->out['file'] = $fileName;

        $this->template = 'Formsan/View/Pdf.phtml';
        parent::execute();
    }

    private function getFront() {
        $page = new Zend_Pdf_Page('420:300');

        $this->cur_Y = self::HEIGHT;

        /* HEADER */
        $y = $this->setNPT_Y();
        $style = $this->getHeadStyle();
        $page->setStyle($style);

        //logo
        $image = Zend_Pdf_Image::imageWithPath($_SERVER['DOCUMENT_ROOT'] . '/img/m-logo-mirage-pdf.png');

        // Draw image 
        $page->drawImage($image, self::MIN_X, $y - 70, self::MIN_X + 152, $y + 60 - 70);



        $page->drawText('Szkółka ogrodnicza', self::MIN_X + 190, $y - 56, 'UTF-8');
        $y = $y - 85; //$this->setNPT_Y();
        $page->drawLine(self::MIN_X, $y, self::MAX_X, $y);

        $style = $this->getOfferStyle();
        $page->setStyle($style);

        $y = $y - 30;
        $page->drawText('Sprzedajemy wysokiej jakości sadzonki drzew i krzewów ozdobnych', self::MIN_X, $y, 'UTF-8');

        $y = $y - 16;
        $page->drawText('oraz roślin wrzosowatych w atrakcyjnych cenach.', self::MIN_X, $y, 'UTF-8');

        // Draw image
        $image = Zend_Pdf_Image::imageWithPath($_SERVER['DOCUMENT_ROOT'] . '/img/ulotka-foto.jpg');
        $page->drawImage($image, self::MAX_X - 75, self::MIN_Y + 20, self::MAX_X, self::MIN_Y + 20 + 90);


        $style = $this->getPriceStyle();
        $page->setStyle($style);

        $y = $y - 20;
        $page->drawText('Krzewy ozdobne oferujemy już od 4 zł za sztukę.', self::MIN_X, $y, 'UTF-8');



        $style = $this->getAddressStyle();
        $page->setStyle($style);
        $y = $y - 20;
        $page->drawText('Katalog roślin dostępny jest pod adresem: sadzonka.eu', self::MIN_X, $y, 'UTF-8');

        $y = $y - 20;
        $page->drawText('Sklep:', self::MIN_X, $y, 'UTF-8');
        $style = $this->getPriceStyle();
        $page->setStyle($style);
        $page->drawText('Siercza 485', self::MIN_X + 38, $y, 'UTF-8');

        $style = $this->getAddressStyle();
        $page->setStyle($style);
        $page->drawText('(południowa granica Wieliczki),', self::MIN_X + 110, $y, 'UTF-8');

        $y = $y - 20;
        $page->drawText('Czynny: od poniedziałku do piątku', self::MIN_X, $y, 'UTF-8');
        $y = $y - 20;
        $page->drawText(' w godzinach 9:00 - 18:00, w soboty 8:00 - 15:00,', self::MIN_X, $y, 'UTF-8');
        $y = $y - 20;
        $page->drawText('Telefon: ', self::MIN_X, $y, 'UTF-8');
        $style = $this->getPriceStyle();
        $page->setStyle($style);
        $page->drawText('519431929', self::MIN_X + 48, $y, 'UTF-8');
        $style = $this->getAddressStyle();
        $page->setStyle($style);
        $page->drawText(', 506455392,', self::MIN_X + 120, $y, 'UTF-8');


        $y = $y - 20;
        $page->drawText('Geolokalizacja: y: 49.976750, x: 20.049963', self::MIN_X, $y, 'UTF-8');


        $style = $this->getInfoStyle();
        $page->setStyle($style);
        $y = $y - 4;
        $page->drawText('mapa dojazdowa na odwrocie >>>', self::MAX_X - 140, $y, 'UTF-8');



        return $page;
    }

    private function getPriceStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#cc0066'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 13;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getHeadStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#336633'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 20;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getAddressStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#330000'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 11;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getOfferStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#330000'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 12;
        $style->setFont($this->font, $this->font_H);

        return $style;
    }

    private function getInfoStyle() {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Html('#336633'));
        $style->setLineWidth(0.1);
        $style->setLineColor(new Zend_Pdf_Color_Html('#eeeeee'));
        $this->font_H = 9;
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

}
