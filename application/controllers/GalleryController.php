<?php

class GalleryController extends Zend_Controller_Action {

	public function indexAction() {
		$this->view->galleries = Core_Model_MapperAbstract::getInstance('Gallery')
				->fetchAll(null, 'folder_date DESC', 20);
		
		foreach ($this->view->galleries as $key => $gallery) {
			if (!$gallery->getActivePhotos()) unset($this->view->galleries[$key]);
		}
	}
}
