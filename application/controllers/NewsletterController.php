<?php

class NewsletterController extends Zend_Controller_Action
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

    	$this->view->form = $this->_getForm();
    }
    
	public function saveAction()
    {
    	null;
    }
    

	private function _getForm() {
		$form = new Application_Form_Newsletter();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}

}

