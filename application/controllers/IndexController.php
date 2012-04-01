<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $home = new Application_Model_InformationMapper();
        $this->view->entries = $home->fetchAll("type='home'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->pictures = $picture->fetchAll("information='main'");
    }
    
	public function indexenAction()
	{
		$this -> _helper->layout()->setLayout("layout_en");
		
		$home = new Application_Model_InformationMapper();
        $this->view->entries = $home->fetchAll("type='home'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->pictures = $picture->fetchAll("information='main'");
	}

}

