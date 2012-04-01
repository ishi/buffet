<?php

class VideoController extends Zend_Controller_Action
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
       /**/
        
    }


}

