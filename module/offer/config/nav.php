<?php

class Module_Offer_Config_Nav extends Module_Config {

    public function get(Manager_Controller $mac) {

        $mac->config(new Module_Common_Config_Basic());

        $url = '/oferta/katalog/typ-';

        $nav = new Model_Collection();

        $link = new Model_Link_Container();
        $link->setId(2)->setUrl($url . 'drzewa-lisciaste,' . Model_Type_Container::FILTER . ',2')->setTitle('drzewa liściaste')->setClass('tree-leaves');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setId(1)->setUrl($url . 'drzewa-iglaste,' . Model_Type_Container::FILTER . ',1')->setTitle('drzewa iglaste')->setClass('tree-coniferous');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setId(4)->setUrl($url . 'krzewy-lisciaste,' . Model_Type_Container::FILTER . ',4')->setTitle('krzewy liściaste')->setClass('bush-leaves');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setId(3)->setUrl($url . 'krzewy-iglaste,' . Model_Type_Container::FILTER . ',3')->setTitle('krzewy iglaste')->setClass('bush-coniferous');
        $nav->append($link);

        $link = new Model_Link_Container();
        $link->setId(5)->setUrl($url . 'wrzosowate,' . Model_Type_Container::FILTER . ',5')->setTitle('wrzosowate')->setClass('heathers');
        $nav->append($link);

        /*$link = new Model_Link_Container();
        $link->setId(6)->setUrl($url . 'byliny,' . Model_Type_Container::FILTER . ',6')->setTitle('byliny')->setClass('perennial');
        $nav->append($link);*/

        $storage = $mac->getStorage();
        $storage->setParam('list-nav', $nav);
        $mac->setStorage($storage);
    }

}
