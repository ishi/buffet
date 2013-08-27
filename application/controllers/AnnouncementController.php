<?php

class AnnouncementController extends Zend_Controller_Action {

	public function indexAction() {
		$order = 'date_from DESC';
		$this->view->entries =
				Application_Model_AnnouncementMapper::getInstance()->fetchAll(null, $order);
	}

	public function detailsAction() {
		$id = $this->_getParam('id');
		if (!$id) {
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		$this->view->entry = 
			Application_Model_AnnouncementMapper::getInstance()->find($id);
	}

}

