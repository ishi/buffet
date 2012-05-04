<?php

class OfferController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $offer = new Application_Model_InformationViewMapper();
        $this->view->entries = $offer->fetchAll("type='oferta'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
    }

}

