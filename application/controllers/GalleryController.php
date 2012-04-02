<?php

class GalleryController extends Zend_Controller_Action {

	public function init() { }

	public function indexAction() {
		$mapper = new Application_Model_GalleryMapper();
		$this->view->galleries = $mapper->fetchAll(null, 'folder_date DESC', 5);
	}
}

