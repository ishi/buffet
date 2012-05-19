<?php

class Admin_GalleryController extends Core_Controller_Action {

	public function indexAction() {
		$this->view->entries = Core_Model_MapperAbstract::getInstance('Gallery')
				->fetchAll(null, 'folder_name ASC');
	}

	public function showAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		
		$this->view->gallery = Core_Model_MapperAbstract::getInstance('Gallery')
				->find($id);
		
		$this->view->form = $this->_getPhotoForm($id);
	}

	public function addAction() {
		$this->view->form = $this->_getForm();
	}

	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		$entry = $mapper->find($id);
		if (!$entry) {
			$this->view->priorityMessenger('Brak galerii o podanym id', 'error');
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		$this->view->form = $this->_getForm();
		$this->view->form->populate($entry->toArray());
	}

	public function removeAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->view->priorityMessenger('Brak id galerii', 'error');
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		try {
			$mapper->delete($id);
			Core_Dir::remove_dir(realpath(APPLICATION_PATH . "/../public/gallery/$id"));
			$this->view->priorityMessenger('Usunięto galerię z bazy danych', 'info');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Błąd przy usuwaniu galerii', 'info');
			$this->view->priorityMessenger($e, 'debug');
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
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		try {
			$gallery->setFolderDate(new Zend_Db_Expr('CURDATE()'));
			$gallery->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$gallery->setUser($this->getLoggedUserName());
			$mapper->save($gallery);
			$this->view->priorityMessenger('Zapisano galerię w bazie danych', 'info');
			
			$dir = APPLICATION_PATH . '/../public/gallery/';
			if (!file_exists($dir)) {
				$this->view->priorityMessenger('Tworzę katalog: ' . $dir, 'debug');
				mkdir($dir);
			}
			$dir .= $gallery->getId() . '/';
			if (!file_exists($dir)) {
				$this->view->priorityMessenger('Tworzę katalog: ' . $dir, 'debug');
				mkdir($dir);
			}
			$this->_redirectToGallery($gallery->getId());
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage(), 'error');
			$this->render('edit');
		}
	}

	private function _getForm() {
		$form = new Admin_Form_Gallery();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	
	public function editPhotoAction() {
		$galleryId = $this->_getParam('galleryId');
		if (!$galleryId) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		$this->view->gallery = $mapper->find($galleryId);

		$photoId = $this->_getParam('id');
		if (!$photoId) {
			$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $galleryId));
			return;
		}
		$mapperP = new Application_Model_PhotoMapper();
		$this->view->photo = $mapperP->find($photoId);
	}

	public function addPhotoAction() {
		$galleryId = $this->_getParam('galleryId');
		if (!$galleryId) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = Core_Model_MapperAbstract::getInstance('Gallery');
		$this->view->gallery = $mapper->find($galleryId);
		
		$this->view->form = $this->_getPhotoForm($galleryId);
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('show');
			return;
		}
		$fileName = $this->view->form->file->getValue();
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas pobierania pliku', 'error');
			$this->render('show');
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		$this->view->priorityMessenger("Zapisałem plik pod nazwą $location", 'debug');
		
		try {
			if ('.zip' == substr($fileName, -4)) {
				$allowedExt = array('jpg', 'png', 'gif');
				$archive = new ZipArchive();
				$archive->open($location);
				$toExtract = array();
				for( $i = 0; $i < $archive->numFiles; $i++ ){ 
					$stat = $archive->statIndex( $i );
					if (!in_array(substr($stat['name'], -3), $allowedExt))
							continue;
					$toExtract[] = $stat['name'];
				}
				if (!$archive->extractTo(APPLICATION_PATH . "/../public/gallery/$galleryId/", $toExtract)) {
					$archive->close();
					throw new Exception('Problem przy rozpakowywaniu archiwum');
				}
				
				foreach ($toExtract as $file) {
					$this->_savePhoto($galleryId, $file);
				}
				unlink(APPLICATION_PATH . "/../public/gallery/$galleryId/$fileName");
				$archive->close();
			} else {
				// Zwykłe zdjęcie
				$this->_savePhoto($galleryId, $fileName);
			}
			$this->_redirectToGallery($galleryId);
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/gallery/$galleryId/$fileName");
			$this->render('show');
		}
	}
	
	private function _savePhoto($galleryId, $fileName) {
		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/gallery/$galleryId/$fileName"))) {
			$this->view->priorityMessenger("W galerii znajduje się już zdjęcie o nazwie $fileName", 'error');
			return;
		}
		
		$photo = new Application_Model_Photo();
		$photo->setName("/gallery/$galleryId/$fileName");
		$photo->setGalleryId($galleryId);
		$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
		
		$photo->setUser($this->getLoggedUserName());
		$photo->setVisible(true);
		$src = APPLICATION_PATH . '/../public/' . $photo->getName();
		$destThumb = APPLICATION_PATH . '/../public/' . $photo->getThumbnailName();
		$destCrop = APPLICATION_PATH . '/../public/' . $photo->getCroppedName();
		
		list($w, $h) = getimagesize($src);
		$crop = array('tw' => 100, 'th' => 100, 'x1' => 0, 'y1' => 0);
		if ($w > $h) {
			$crop['x1'] = ($w - $h) / 2; 
			$crop['w'] = $crop['h'] = $h;
		} else {
			$crop['y1'] = ($h - $w) / 2;
			$crop['w'] = $crop['h'] = $w;
		}
		
		Core_Image::crop($src, $destThumb, $crop);
		$crop['tw'] = $crop['th'] = $crop['w'];
		Core_Image::crop($src, $destCrop, $crop);
		
		$mapper->save($photo);
		$this->view->priorityMessenger("Zapisano zdjęcie w bazie danych $fileName");
	}
	
	public function removePhotoAction() {
		$id = $this->_getParam('id');
		$galleryId = $this->_getParam('galleryId');
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia', 'error');
			$this->_redirectToGallery($galleryId);
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
		$this->_redirectToGallery($galleryId);
	}
	
	public function togglePhotoAction() {
		$id = $this->_getParam('id');
		$galleryId = $this->_getParam('galleryId');
		
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia', 'error');
			$this->_redirectToGallery($galleryId);
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
		$this->_redirectToGallery($galleryId);
	}

	public function cropPhotoAction () {
		$galleryId = $this->_getParam('galleryId');
		if (!$galleryId) {
			$this->view->priorityMessenger('Brak id galerii', 'error');
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		
		$id = $this->_getParam('id');
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia do edycji', 'error');
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		
		$photo = Core_Model_MapperAbstract::getInstance('Photo')->find($id);
		if (!$photo) {
			$this->view->priorityMessenger('Zdjęcie o podanym id nie istnieje', 'error');
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		$crop = $this->_getParam('crop', array());
		foreach ($crop as &$val)
			$val = round($val);
		
		$crop['tw'] = $crop['w'];
		$crop['th'] = $crop['h'];
		Core_Image::crop(APPLICATION_PATH . '/../public/' . $photo->getName(), 
			APPLICATION_PATH . '/../public/' . $photo->getCroppedName(), $crop);
		
		$crop['tw'] = $crop['th'] = 100;
		Core_Image::crop(APPLICATION_PATH . '/../public/' . $photo->getName(), 
			APPLICATION_PATH . '/../public/' . $photo->getThumbnailName(), $crop);
		
		$this->_redirectToGallery($galleryId);
	}

	private function _getPhotoForm($galleryId = null) {
		$form = new Admin_Form_Photo();
		$form->setAction($this->_helper->url('add-photo'));
		if ($galleryId) {
			$form->file->setDestination(APPLICATION_PATH . "/../public/gallery/$galleryId");
			$form->populate(array('galleryId' => $galleryId));
		}
		return $form;
	}
	
	private function _redirectToGallery($galleryId) {
		$this->_helper->redirector->gotoSimple('show', 'gallery', null, array('id' => $galleryId))
			->redirectAndExit();
	}
}