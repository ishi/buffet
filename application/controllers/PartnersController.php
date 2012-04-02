<?php

class PartnersController extends Zend_Controller_Action
{

    public function init()
    {
    	if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $this->_getParam('lang', 'pl');
        
    	if ($_SESSION['lang']=='en'){
        	$this -> _helper->layout()->setLayout("layout_en");
        }
        else{
        	$this -> _helper->layout()->setLayout("layout");
        }
    }

    public function indexAction()
    {
    	
    	$picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
        
        $partner = new Application_Model_PictureMapper();
        $this->view->partners = $partner->fetchAll("information='partners'");
    }

}

