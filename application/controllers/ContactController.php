<?php

class ContactController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $information = new Application_Model_InformationMapper();
        $this->view->entries = $information->fetchAll("type='kontakt'");
    }

}

