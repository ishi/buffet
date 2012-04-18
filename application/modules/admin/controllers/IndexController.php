<?php

class Admin_IndexController extends Zend_Controller_Action
{
    public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    }

    public function indexAction()
    {	
    	$news = new Application_Model_EventMapper();
        $order = 'date_from DESC';
        $this->view->entries = $news->fetchAll("id", $order);
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        /*$home = new Application_Model_InformationMapper();
        $this->view->entries = $home->fetchAll("type='home'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->pictures = $picture->fetchAll("information='main'");
        */
    }
    
	public function detailsAction()
    {
    	$news = new Application_Model_EventMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id", "id");
    }    
    
	

}

