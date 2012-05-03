<?php

class Admin_GalleryController extends Zend_Controller_Action {

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
			$this->remove_dir(realpath(APPLICATION_PATH . "/../public/gallery/$id"));
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
			$gallery->setUser('seta');
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
			$dir .= 'thumb/';
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
		
		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/gallery/$galleryId/$fileName"))) {
			$this->view->priorityMessenger("W galerii znajduje się już zdjęcie o nazwie $fileName", 'error');
			$this->_redirectToGallery($galleryId);
			return;
		}
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas pobierania pliku', 'error');
			$this->render('show');
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		$this->view->priorityMessenger("Zapisałem plik pod nazwą $location", 'debug');
		
		$photo = new Application_Model_Photo();
		try {
			$photo->setName("/gallery/$galleryId/$fileName");
			$photo->setGalleryId($galleryId);
			$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photo->setUser('seta');
			$photo->setVisible(true);
			$mapper->save($photo);
			$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
			$this->_redirectToGallery($galleryId);
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/gallery/$galleryId/$fileName");
			$this->render('show');
		}
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
		$type = strtolower(substr(strrchr($src,"."),1));

		$this->_resizePhoto(APPLICATION_PATH . '/../public/' . $photo->getName(), 
			APPLICATION_PATH . '/../public/' . $photo->getCroppedName(), $crop);
		
		$crop['tw'] = $crop['th'] = 100;
		$this->_resizePhoto(APPLICATION_PATH . '/../public/' . $photo->getName(), 
			APPLICATION_PATH . '/../public/' . $photo->getThumbnailName(), $crop);
		
		$this->_redirectToGallery($galleryId);
	}
	
	private function _resizePhoto($src, $dest, array $options) {
		$type = strtolower(substr(strrchr($src,"."),1));
  		if($type == 'jpg') $type = 'jpeg';
  		switch($type){
    			case 'bmp': $img = imagecreatefromwbmp($src); break;
    			case 'gif': $img = imagecreatefromgif($src); break;
    			case 'jpeg': $img = imagecreatefromjpeg($src); break;
    			case 'png': $img = imagecreatefrompng($src); break;
    			default : return "Unsupported picture type!";
  		}

		$new = ImageCreateTrueColor($options['tw'], $options['th']);
		// preserve transparency
  		if($type == "gif" or $type == "png"){
    			imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    			imagealphablending($new, false);
    			imagesavealpha($new, true);
  		}
		
		imagecopyresampled($new, $img, 0, 0, $options['x1'], $options['y1'],
    			$options['tw'], $options['th'], $options['w'], $options['h']);

		if (null == $dest) {
			header("Content-type: image/$type");
		}
		switch($type){
			case 'bmp': imagewbmp($new, $dest, 100); break;
			case 'gif': imagegif($new, $dest, 100); break;
			case 'jpeg': imagejpeg($new, $dest, 100); break;
			case 'png': imagepng($new, $dest, 100); break;
		}
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
		$this->_helper->redirector->gotoSimple('show', 'gallery', null, array('id' => $galleryId));
	}
	
	function remove_dir($dir) { 
		if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
		
        foreach (scandir($dir) as $file) { 
            if ($file == '.' || $file == '..') continue; 
            if (!$this->remove_dir($dir . DIRECTORY_SEPARATOR . $file)) { 
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777); 
                if (!$this->remove_dir($dir . DIRECTORY_SEPARATOR . $file)) return false; 
            }; 
        } 
        return rmdir($dir); 
    } 
}

