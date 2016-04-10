<?php

// /oferta/katalog/roslina-klon-polny,pid,1,sid,1
class Offer_Module_Single extends Module_Abstract {

    function execute() {
        $this->in['idCategory'] = (int) $this->request->get(Model_Plant_Category_Container::FILTER);
        $this->in['id'] = (int) $this->request->get(Model_Plant_Container::FILTER);
                
        if ($this->in['id'] <= 0) {
            throw new Manager_Exception_NotFound();
        }
        try {
            $this->out['category'] = $this->storage->getParam('list-nav')->search('id', $this->in['idCategory']);
            
            if ($this->out['category'] instanceof Model_Link_Container) {

                $api = new Model_Plant_Source_Api(Model_Plant_Source_Factory::DB_MYSQL);
                $this->out['plant'] = $api->getPlantById($this->in['id']);
                
                
                $this->storage->pageId = $this->out['category']->getClass();
                $this->out['category']->setActive($this->storage->pageId);

                $this->storage->metatags->setTitle('Roślina: ' . $this->out['plant']->getName() . ' - ');
                $this->storage->metatags->setDescription(' - Roślina: ' . $this->out['plant']->getDescription(), 'append');
                $this->storage->metatags->setKeywords($this->out['plant']->getName() . ',');

                $link = new Model_Link_Container();
                $link->setUrl('/oferta')->setTitle('Oferta');
                $this->storage->breadcrumbs->set(1, $link);

                $link = new Model_Link_Container();
                $link->setUrl($this->out['category']->getUrl())->setTitle(' (typ) ' . $this->out['category']->getTitle());
                $this->storage->breadcrumbs->set(2, $link);
                
                $link = new Model_Link_Container();
               $link->setTitle(' (roślina) ' . $this->out['plant']->getName());
                $this->storage->breadcrumbs->set(3, $link);
                
                
            } else {
                throw new Manager_Exception_NotFound();
            }
        } catch (Model_Exception_NotFound $e) {
            
            //echo $e->getMessage();exit;
            throw new Manager_Exception_NotFound();
        } catch (Exception $e) {
             //echo $e->getMessage();exit;
            throw new Manager_Exception_Unavailable();
        }
        $this->template = 'Offer/View/Single.phtml';
        parent::execute();
    }
}
