<?php

class Admin_InformationController extends Zend_Controller_Action
{
	public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    	//if(!isset($_SESSION['event_kind'])) $_SESSION['event_kind'] = $this->_getParam('where', 'news');
    }
    
    public function indexAction()
    {
    	$information = new Application_Model_InformationMapper();
    	$where = 'id IS NOT NULL';
    	$order = 'type';
        $this->view->entries = $information->fetchAll($where, $order);

    }
    
	public function addAction() {
		$this->view->form = $this->_getForm();
	}
	
	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_InformationMapper();
		$entry = $mapper->find($id);
		$this->view->form = $this->_getForm();
		$this->view->form->populate($entry->toArray());
	}
	
	public function saveAction() {
		$this->view->form = $this->_getForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('edit');
			return;
		}
		
		$information = new Application_Model_Information($this->_getAllParams());
		$mapper = new Application_Model_InformationMapper();
		try {
			$information->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$information->setUser($this->getLoggedUserName());
			$information->getPictureId();
			
			$mapper->save($information);
			$this->view->priorityMessenger('Zapisano w bazie danych');
			$this->_helper->redirector->gotoSimple('index');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: ' 
					. $e->getMessage());
			$this->render('edit');
		}
	}
	
	private function _getForm() {
		$form = new Admin_Form_Information();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	

}

