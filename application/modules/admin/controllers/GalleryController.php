<?php

class Admin_GalleryController extends Zend_Controller_Action {

	public function indexAction() {
		$mapper = new Application_Model_GalleryMapper();
		$this->view->entries = $mapper->fetchAll(null, 'folder_name ASC');
	}
	
	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_GalleryMapper();
		$this->view->entry = $mapper->find($id);
	}
}

