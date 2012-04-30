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
        
        //if (!isset($_GET['lang'])) $_GET['lang'] = 'pl';
        
    }

    public function indexAction()
    {
    	$picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='main'");

    	$this->view->form = $this->_getForm();
    }
    
	public function saveAction() {
		$this->view->form = $this->_getForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('index');
			return;
		}
		
		$newsletter = new Application_Model_Newsletter($this->_getAllParams());
		$mapper = new Application_Model_NewsletterMapper();
		try {
			$newsletter->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$newsletter->setUser('ola');
			$newsletter->setPotwierdzenie('N');
			
			$mapper->save($newsletter);
			$this->view->priorityMessenger('Zapisano e-mail w bazie danych');
			//$this->_helper->redirector->gotoSimple('index');
			$this->_helper->redirector->gotoSimple('index', 'newsletter', null, array('lang' => $_SESSION['lang']));
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: ' 
					. $e->getMessage());
			$this->render('index');
		}
	}
    

	private function _getForm() {
		$form = new Application_Form_Newsletter();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}

}

