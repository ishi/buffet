<?php

class Admin_PartnerController extends Zend_Controller_Action
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
        $this->view->entries = $picture->fetchAll("information='partners'");
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
		$mapper = new Application_Model_GalleryMapper();
		$this->view->gallery = $mapper->find($galleryId);
	}
	
	public function savePhotoAction() {
		$this->view->form = $this->_getPhotoForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('index');
			return;
		}
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		$galleryId = $this->view->form->gallery_id->getValue();
		$fileName = $this->view->form->file->getValue();
		
		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/pictures/partners/$fileName"))) {
			$this->view->priorityMessenger("W galerii znajduje się już zdjęcie o nazwie $fileName");
			$this->_helper->redirector->gotoSimple('index', 'picture', null);
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		
		$newLocation = realpath(APPLICATION_PATH . "/../public/pictures/partners/") . "/$fileName";
		if (!copy($location, $newLocation)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $location do $newLocation");
			$this->render('index');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $location do $newLocation");
		
		$photo = new Application_Model_Photo($this->_getAllParams());
		try {
			$photo->setName("/pictures/partners/$fileName");
			$photo->setGalleryId(null);
			$photo->setInformation('PARTNERS');
			$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photo->setUser('ola');
			$mapper->save($photo);
			var_dump($photo->getId());
			$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
			$this->_helper->redirector->gotoSimple('index', 'partner', null);
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/partners/$fileName");
			$this->render('add-photo');
		}
	}
	
	public function removePhotoAction() {
		$id = $this->_getParam('id');
		
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia', 'error');
			$this->_helper->redirector->gotoSimple('index', 'partner', null);
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
		$this->_helper->redirector->gotoSimple('index', 'partner', null);
	}
	
	private function _getForm() {
		$form = new Admin_Form_Information();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	
	private function _getPhotoForm() {
		$form = new Admin_Form_PhotoP();
		$form->setAction($this->_helper->url('save-photo'));
		return $form;
	}
	

}

