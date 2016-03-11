<?php

class Offer_Module_List extends Module_Abstract {

    function execute() {

        $this->in['id'] = $this->request->get(Model_Type_Container::FILTER, 'html');
        if ($this->in['id'] <= 0) {
            throw new Manager_Exception_NotFound();
        }

        try {
            $this->out['category'] = $this->storage->getParam('list-nav')->search('id', $this->in['id']);
            if ($this->out['category'] instanceof Model_Link_Container) {
                
                $api = new Model_Plant_Source_Api(Model_Plant_Source_Factory::DB_MYSQL);
                $this->out['list'] = $api->getCategoryPlantsById($this->in['id']);
                
                $this->storage->pageId = $this->out['category']->getClass();
                $this->out['category']->setActive($this->storage->pageId);

                $this->storage->metatags->setTitle('Typ: ' . $this->out['category']->getTitle() . ' - ');
                $this->storage->metatags->setDescription(' - Typ: ' . $this->out['category']->getTitle(), 'append');
                $this->storage->metatags->setKeywords($this->out['category']->getTitle() . ',');

                $link = new Model_Link_Container();
                $link->setUrl('/oferta')->setTitle('Oferta');
                $this->storage->breadcrumbs->set(1, $link);

                $link = new Model_Link_Container();
                $link->setTitle(' (typ) ' . $this->out['category']->getTitle());
                $this->storage->breadcrumbs->set(2, $link);
            } else {
                throw new Manager_Exception_NotFound();
            }
        } catch (Model_Exception_NotFound $e) {
            throw new Manager_Exception_NotFound();
        } catch (Exception $e) {
            throw new Manager_Exception_Unavailable();
        }
        $this->template = 'Offer/View/List.phtml';
        parent::execute();
    }

}
