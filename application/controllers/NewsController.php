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

