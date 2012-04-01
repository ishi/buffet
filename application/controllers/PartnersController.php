<?php

class PartnersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	$picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
        
        $partner = new Application_Model_PictureMapper();
        $this->view->partners = $partner->fetchAll("information='partners'");
    }

}

