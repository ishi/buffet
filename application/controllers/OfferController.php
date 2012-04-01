<?php

class OfferController extends Zend_Controller_Action
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
        // action body
        //$this->view->tables = $this->getInvokeArg('bootstrap')->getResource('db')->listTables();
        $offer = new Application_Model_InformationMapper();
        $this->view->entries = $offer->fetchAll("type='oferta'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");
    }

}

