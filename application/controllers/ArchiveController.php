<?php

class ArchiveController extends Zend_Controller_Action {

	public function indexAction() {
		$order = 'date_from DESC';
		$entries = Application_Model_ArchiveMapper::getInstance()->fetchAll(null, $order);
		$entriesTable = array();
		foreach ($entries as $key => $entry) {
			$entriesTable[$key % 3][] = $entry;
		}
		$this->view->entriesTable = $entriesTable;
	}

	public function detailsAction() {
		$id = $this->_getParam('id');
		if (!$id) {
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		$this->view->entry = Application_Model_ArchiveMapper::getInstance()->find($id);
	}

}

