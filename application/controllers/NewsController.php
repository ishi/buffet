<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
    	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $this->_getParam('lang', 'pl');;
        
    	if ($_SESSION['lang']=='en'){
        	$this -> _helper->layout()->setLayout("layout_en");
        }
        else{
        	$this -> _helper->layout()->setLayout("layout");
        }
        
    }

    public function indexAction()
    {
    	
        $news = new Application_Model_NewsMapper();
        $order = 'date_from DESC';
        $this->view->entries = $news->fetchAll("id", $order);
    }
    
    public function detailsAction()
    {
    	$news = new Application_Model_NewsMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id", "id");
    }


}

