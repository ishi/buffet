<?php

class NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $news = new Application_Model_NewsMapper();
        $this->view->entries = $news->fetchAll("id");
    }
    
    public function detailsAction()
    {
    	$news = new Application_Model_NewsMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id");
    	
    }


}

