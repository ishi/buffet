<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	$this -> _helper->layout()->setLayout("layout");
        if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $this->_getParam('lang', 'pl');
        
    	if ($_SESSION['lang']=='en'){
        	$this -> _helper->layout()->setLayout("layout_en");
        }
        else{
        	$this -> _helper->layout()->setLayout("layout");
        }
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
    
	

}

