<?php

class ContactController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $information = new Application_Model_InformationViewMapper();
        $this->view->entries = $information->fetchAll("type='kontakt'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
    }

}

