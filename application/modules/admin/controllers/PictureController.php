<?php

class Admin_PictureController extends Core_Controller_Action
{
	public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    	//if(!isset($_SESSION['event_kind'])) $_SESSION['event_kind'] = $this->_getParam('where', 'news');
    }
    
    public function indexAction()
    {	
    	$this->view->form = $this->_getPhotoForm();
    	
    	$picture = new Application_Model_PictureMapper();
        $this->view->entries = $picture->fetchAll("information='main'");
    }
    
	public function addPhotoAction() {
		$this->view->form = $this->_getPhotoForm();
		$galleryId = null;
		/*
		if (!$galleryId) {
			$this->view->priorityMessenger('Brak id galerii');
			$this->_helper->redirector->gotoSimple('index', 'gallery');
			return;
		}
		*/
		$this->view->form->populate(array('gallery_id' => $galleryId));
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		$this->view->gallery = $mapper->find($galleryId);
	}
	
	public function savePhotoAction() {
		$this->view->form = $this->_getPhotoForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('add');
			return;
		}
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('add');
			return;
		}
		$fileName = $this->view->form->file->getValue();
		
		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/pictures/$fileName"))) {
			$this->view->priorityMessenger("W galerii znajduje się już zdjęcie o nazwie $fileName");
			$this->_helper->redirector->gotoSimple('index', 'picture', null);
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		
		$newLocation = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileName";
		if (!copy($location, $newLocation)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $location do $newLocation");
			$this->render('add');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $location do $newLocation");
		
		$photo = new Application_Model_Photo();
		try {
			$photo->setName("/pictures/$fileName");
			$photo->setGalleryId(null);
			$photo->setInformation('MAIN');
			$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photo->setUser($this->getLoggedUserName());
			$mapper->save($photo);
			$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
			$this->_helper->redirector->gotoSimple('index', 'picture', null);
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileName");
			$this->render('add-photo');
		}
	}
	
	public function removePhotoAction() {
		$id = $this->_getParam('id');
		
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia', 'error');
			$this->_helper->redirector->gotoSimple('index', 'picture', null);
			return;
		}
		
		$mapper = new Application_Model_PhotoMapper();
		try {
			$photo = $mapper->find($id);
			$mapper->delete($id);
			unlink(APPLICATION_PATH . '/../public/' . $photo->getName());
			$this->view->priorityMessenger('Usunięto zdjęcie z bazy: ' . $photo->getName(), 'info');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Błąd podczas usuwania zdjęcia', 'error');
			$this->view->priorityMessenger($e, 'debug');
		}
		$this->_helper->redirector->gotoSimple('index', 'picture', null);
	}
	
	public function togglePhotoAction() {
		$id = $this->_getParam('id');
		
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia', 'error');
			$this->_helper->redirector->gotoSimple('index', 'picture', null);
			return;
		}
		
		$mapper = new Application_Model_PhotoMapper();
		try {
			$photo = $mapper->find($id);
			$photo->setVisible(!$photo->isVisible());
			$mapper->save($photo);
			$this->view->priorityMessenger(($photo->isVisible() ? 'Uwidoczniono' : 'Ukryto')
					. ' zdjęcie' . $photo->getName(), 'info');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Błąd podczas zmiany widoczności zdjęcia', 'error');
			$this->view->priorityMessenger($e, 'debug');
		}
		$this->_helper->redirector->gotoSimple('index', 'picture', null);
	}
	
	private function _getForm() {
		$form = new Admin_Form_Information();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	
	private function _getPhotoForm() {
		$form = new Admin_Form_Photo();
		$form->setAction($this->_helper->url('save-photo'));
		return $form;
	}
	

}

