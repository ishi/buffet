<?php

class ArchiveController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $archive = new Application_Model_ArchiveMapper();
        $this->view->entries = $archive->fetchAll("id");  
    }

	public function detailsAction()
    {
    	$news = new Application_Model_ArchiveMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id");
    }

}

