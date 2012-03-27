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
        $this->view->entries = $archive->fetchAll();
        
    }


}

