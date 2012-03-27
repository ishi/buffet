<?php

class OfferController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $offer = new Application_Model_InformationMapper();
        $this->view->entries = $offer->fetchAll("type='oferta'");
    }

}

