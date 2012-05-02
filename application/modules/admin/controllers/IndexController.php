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

    }
    
	public function detailsAction()
    {
    	$news = new Application_Model_EventMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll(array("id=?" => $id), "id");
    }    
}

