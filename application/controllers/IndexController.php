<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $home = new Application_Model_InformationViewMapper();
        $this->view->entries = $home->fetchAll("type='home'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->pictures = $picture->fetchAll("information='main'");
    }
    
	

}

