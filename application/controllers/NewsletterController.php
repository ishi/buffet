<?php

class NewsletterController extends Zend_Controller_Action
{

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
			echo "111";
			$newsletter->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$newsletter->setUser('ola');
			$newsletter->setPotwierdzenie('N');
			echo "222";
			$mapper->save($newsletter);
			echo "333";
			$this->view->priorityMessenger('Zapisano e-mail w bazie danych');
			
			//$this->_helper->redirector->gotoSimple('index');
			$this->_helper->redirector->gotoSimple('index', 'newsletter', null);
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

