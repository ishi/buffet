<?php

class AnnouncementController extends Zend_Controller_Action
{

    public function init()
    {
        if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $this->_getParam('lang', 'pl');
        $lang = $this->_getParam('lang', 'pl');
        $_SESSION['lang'] = $lang;
        echo $_SESSION['lang'];
        
    	if ($_SESSION['lang']=='en'){
        	$this -> _helper->layout()->setLayout("layout_en");
        }
        else{
        	$this -> _helper->layout()->setLayout("layout");
        }
    }

    public function indexAction()
    {
        $announcement = new Application_Model_AnnouncementMapper();
        $order = 'date_from DESC';
        $this->view->entries = $announcement->fetchAll("id", $order);        
    }
	
	public function detailsAction()
    {
    	$news = new Application_Model_AnnouncementMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id", "id");
    	
    }

}

