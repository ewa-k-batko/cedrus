<?php

class Gallery_Module_List extends Module_Abstract {

    function execute() {
        $this->out['list'] = array(
            '_IGP2583_400.jpg',
            '_IGP1438_400.jpg',            
            '_IGP2383_400.jpg', 
             '_IGP2829_400.jpg',
            '_IGP1364_400.jpg',
           
            '_IGP1416_400.jpg',
            
            '_IGP1417_400.jpg',
            '_IGP1425_400.jpg',
            '_IGP1427_400.jpg',
            '_IGP2819_400.jpg',
            
             '_IGP1413_400.jpg',
            '_IGP2587_400.jpg',
            
            '_IGP2817_400.jpg',
            
           
            
            '_IGP2837_400.jpg',
            '_IGP2842_400.jpg',
            '_IGP4474_400.jpg',
            '_IGP2565_400.jpg',
            '_IGP2357_400.jpg',
            '_IGP1393_400.jpg',
            '_IGP2654_400.jpg',
            
            '_IGP2830_400.jpg',
            '_IGP2566_400.jpg',
            '_IGP2317_400.jpg',
            '_IGP2570_400.jpg',
        );

           //shuffle($this->out['list']);
        $this->out['path'] = 'g/';



        //$this->in['id'] = $this->request->get(Model_Type_Container::FILTER, 'html');

        /* if ($this->in['id'] > 0) {
          try {
          $this->out['product'] = $this->storage->getParam('list-nav')->search('id', $this->in['id']);

          if ($this->out['product'] instanceof Model_Link_Container) {
          $this->storage->pageId = $this->out['product']->getClass();
          $this->out['product']->setActive($this->storage->pageId);

          $this->storage->metatags->setTitle('Typ: ' . $this->out['product']->getTitle() . ' - ');
          $this->storage->metatags->setDescription(' - Typ: ' . $this->out['product']->getTitle(), 'append');
          $this->storage->metatags->setKeywords($this->out['product']->getTitle() . ',');


          $link = new Model_Link_Container();
          $link->setUrl('/galeria')->setTitle('Galeria');
          $this->storage->breadcrumbs->set(1, $link);


          } else {
          throw new Manager_Exception_NotFound();
          }
          } catch (Exception $e) {
          throw new Manager_Exception_NotFound();
          }
          } */
        $this->template = 'gallery/view/list.phtml';
        parent::execute();
    }

}
