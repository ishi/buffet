<?php

class GalleryController extends Zend_Controller_Action {

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

	public function indexAction() {
		$mapper = new Application_Model_GalleryMapper();
		$this->view->galleries = $mapper->fetchAll(null, 'folder_date DESC', 20);
		foreach ($this->view->galleries as $key => $gallery) {
			if (!$gallery->getPhotos()) unset($this->view->galleries[$key]);
		}
	}
}