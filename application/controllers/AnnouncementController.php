<?php

class AnnouncementController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $announcement = new Application_Model_AnnouncementMapper();
        $this->view->entries = $announcement->fetchAll("id");        
    }
	
	public function detailsAction()
    {
    	$news = new Application_Model_AnnouncementMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id");
    	
    }

}

