<?php

class Admin_GalleryController extends Zend_Controller_Action {

	public function indexAction() {
		$mapper = new Application_Model_GalleryMapper();
		$this->view->entries = $mapper->fetchAll(null, 'folder_name ASC');
	}

	public function showAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		
		$mapper = new Application_Model_GalleryMapper();
		$this->view->gallery = $mapper->find($id);
	}

	public function addAction() {
		$this->view->form = $this->_getForm();
	}

	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_GalleryMapper();
		$entry = $mapper->find($id);
		$this->view->form = $this->_getForm();
		$this->view->form->populate($entry->toArray());
	}

	public function removeAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->view->priorityMessenger('Brak id galerii');
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_GalleryMapper();
		if (!$mapper->delete($id)) {
			$this->view->priorityMessenger('Błąd przy usuwaniu galerii', 'info');
		} else {
			$this->view->priorityMessenger('Usunięto galerię z bazy danych');
		}
		$this->_helper->redirector->gotoSimple('index');
	}

	public function saveAction() {
		$this->view->form = $this->_getForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('edit');
			return;
		}

		$gallery = new Application_Model_Gallery($this->_getAllParams());
		$mapper = new Application_Model_GalleryMapper();
		try {
			$gallery->setFolderDate(new Zend_Db_Expr('CURDATE()'));
			$gallery->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$gallery->setUser('seta');
			$mapper->save($gallery);
			$this->view->priorityMessenger('Zapisano galerię w bazie danych');
			$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $gallery->getId()));
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			$this->render('edit');
		}
	}

	private function _getForm() {
		$form = new Admin_Form_Gallery();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}

}

