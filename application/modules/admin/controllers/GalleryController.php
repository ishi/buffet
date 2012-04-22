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
			
			$dir = APPLICATION_PATH . '/../public/gallery/';
			if (!file_exists($dir)) {
				$this->view->priorityMessenger('Tworzę katalog: ' . $dir);
				mkdir($dir);
			}
			$dir .= $gallery->getId() . '/';
			if (!file_exists($dir)) {
				$this->view->priorityMessenger('Tworzę katalog: ' . $dir);
				mkdir($dir);
			}
			$dir .= 'thumb/';
			if (!file_exists($dir)) {
				$this->view->priorityMessenger('Tworzę katalog: ' . $dir);
				mkdir($dir);
			}
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
	
	
	public function addPhotoAction() {
		$this->view->form = $this->_getPhotoForm();
		$galleryId = $this->_getParam('galleryId');
		if (!$galleryId) {
			$this->view->priorityMessenger('Brak id galerii');
			$this->_helper->redirector->gotoSimple('index', 'gallery');
			return;
		}
		$this->view->form->populate(array('gallery_id' => $galleryId));
		$mapper = new Application_Model_GalleryMapper();
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
		$galleryId = $this->view->form->gallery_id->getValue();
		$fileName = $this->view->form->file->getValue();
		
		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/gallery/$galleryId/$fileName"))) {
			$this->view->priorityMessenger("W galerii znajduje się już zdjęcie o nazwie $fileName");
			$this->_helper->redirector->gotoSimple('show', 'gallery', null, array('id' => $galleryId));
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		
		$newLocation = realpath(APPLICATION_PATH . "/../public/gallery/$galleryId/") . "/$fileName";
		if (!copy($location, $newLocation)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $location do $newLocation");
			$this->render('add');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $location do $newLocation");
		
		$photo = new Application_Model_Photo();
		try {
			$photo->setName("/gallery/$galleryId/$fileName");
			$photo->setGalleryId($galleryId);
			$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photo->setUser('seta');
			$mapper->save($photo);
			$this->view->priorityMessenger('Zapisano galerię w bazie danych');
			$this->_helper->redirector->gotoSimple('show', 'gallery', null, array('id' => $galleryId));
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/gallery/$galleryId/$fileName");
			$this->render('add-photo');
		}
	}

	private function _getPhotoForm() {
		$form = new Admin_Form_Photo();
		$form->setAction($this->_helper->url('save-photo'));
		return $form;
	}

}

