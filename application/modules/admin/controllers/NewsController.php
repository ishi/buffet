<?php

class Admin_NewsController extends Zend_Controller_Action
{

    public function init()
    {
    	/**/
    	$this -> _helper->layout()->setLayout("layout_admin");
    }

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        /*$home = new Application_Model_InformationMapper();
        $this->view->entries = $home->fetchAll("type='home'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->pictures = $picture->fetchAll("information='main'");
        */
    }
    
	

}
