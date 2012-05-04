<?php

class PartnersController extends Zend_Controller_Action
{

    public function indexAction()
    {
    	
    	$picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
        
        $partner = new Application_Model_PictureMapper();
        $this->view->partners = $partner->fetchAll("information='partners'");
    }

}

