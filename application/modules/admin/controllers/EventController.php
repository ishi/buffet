<?php

class Admin_EventController extends Core_Controller_Action {

	public function init() {
		$_SESSION['event_kind'] = $this->_getParam('where', 'news');
		if (!isset($_SESSION['event_kind']))
			$_SESSION['event_kind'] = $this->_getParam('where', 'news');
		$dir = APPLICATION_PATH . '/../public/pictures/';
		if (!file_exists($dir)) {
			$this->view->priorityMessenger('Tworzę katalog: ' . $dir, 'debug');
			mkdir($dir);
		}
	}

	public function indexAction() {
		$event = new Application_Model_EventMapper();

		$param = $this->_getParam('where', 'news');
		if ($param == 'news') {
			$where = 'event_news = \'T\'';
		} elseif ($param == 'announcement') {
			$where = 'event_announcement = \'T\' and ((
										date_to IS NOT NULL AND date_format(date_to, \'%Y-%m-%d\') >= date_format(now(), \'%Y-%m-%d\')
										)
										OR (
										date_to IS NULL AND date_format(date_from, \'%Y-%m-%d\') >= date_format(now(), \'%Y-%m-%d\')))';
		} elseif ($param == 'archive') {
			$where = 'event_announcement = \'T\' and ((
										date_format(date_to, \'%Y-%m-%d\') IS NOT NULL AND date_format(date_to, \'%Y-%m-%d\') < date_format(now(), \'%Y-%m-%d\')
										)
										OR (
										date_format(date_to, \'%Y-%m-%d\') IS NULL AND date_format(date_from, \'%Y-%m-%d\') < date_format(now(), \'%Y-%m-%d\')))';
		} else {
			$where = 'event_news = \'T\'';
		}
		$order = 'date_from DESC';

		$this->view->entries = $event->fetchAll($where, $order);
	}

	public function showAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}

		$mapper = new Application_Model_EventMapper();
		$this->view->event = $mapper->find($id);

		$this->view->form = $this->_getPhotoForm();

		$this->view->form->id->setValue($this->view->event->getPictureId());
		$this->view->form->idS->setValue($this->view->event->getPictureIdSmall());
		$this->view->form->idA->setValue($this->view->event->getPictureIdArchive());
		$this->view->form->eventId->setValue($id);
	}

	public function addAction() {
		$this->view->form = $this->_getForm();
	}

	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_EventMapper();
		$entry = $mapper->find($id);
		$this->view->form = $this->_getEditForm();
		//$this->view->form = $this->_getForm();
		$this->view->form->populate($entry->toArray());

		$event_news = $this->view->form->event_news->getValue();
		$event_announcement = $this->view->form->event_announcement->getValue();
		if ($event_news == 'T') {
			$this->view->form->event_kind->setValue('N');
		} elseif ($event_announcement == 'T') {
			$this->view->form->event_kind->setValue('Z');
		}


		$this->view->form->removeElement('file');
		$this->view->form->removeElement('file2');
		$this->view->form->removeElement('file3');
	}

	public function removeAction() {

		if (!($id = $this->_getParam('id'))) {
			$this->view->priorityMessenger('Brak id eventu');
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_EventMapper();

		$event = $mapper->find($id);
		$picture_id = $event->getPictureId();
		$picture_id_small = $event->getPictureIdSmall();
		$picture_id_archive = $event->getPictureIdArchive();

		Zend_Db_Table::getDefaultAdapter()->beginTransaction();
		if ($picture_id) {
			$mapper2 = new Application_Model_PictureMapper();
			$picture = $mapper2->find($picture_id);
			$picture_name = $picture->getName();

			if ($picture_name != NULL) {
				if (!unlink(APPLICATION_PATH . "/../public$picture_name")) {
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				} else {
					if (!$mapper2->delete($picture_id)) {
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else {
						null; //$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}
		}


		if ($picture_id_small) {
			$mapper3 = new Application_Model_PictureMapper();
			$picture3 = $mapper3->find($picture_id_small);
			$picture_name_small = $picture3->getName();
			if ($picture_name_small != NULL) {
				if (!unlink(APPLICATION_PATH . "/../public$picture_name_small")) {
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				} else {
					if (!$mapper3->delete($picture_id_small)) {
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else {
						null; //$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}
		}

		if ($picture_id_archive) {
			$mapper4 = new Application_Model_PictureMapper();
			$picture4 = $mapper4->find($picture_id_archive);
			$picture_name_archive = $picture4->getName();
			if ($picture_name_archive != NULL) {
				if (!unlink(APPLICATION_PATH . "/../public$picture_name_archive")) {
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				} else {
					if (!$mapper4->delete($picture_id_archive)) {
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else {
						null; //$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}
		}

		if (!$mapper->delete($id)) {
			$this->view->priorityMessenger('Błąd przy usuwaniu eventu');
		} else {
			$this->view->priorityMessenger('Usunięto event z bazy danych');
		}

		Zend_Db_Table::getDefaultAdapter()->commit();

		$this->_helper->redirector->gotoSimple('index', 'event', null, array('where' => $this->_getParam('where')));
	}

	public function saveAction() {
		$this->view->form = $this->_getForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('edit');
			return;
		}

		try {
			//event
			$event = new Application_Model_Event($this->_getAllParams());
			$mapper = new Application_Model_EventMapper();
			$event->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$event->setUser($this->getLoggedUserName());
			
			$event_kind = $this->view->form->event_kind->getValue();
			if ($event_kind == 'N') {
				$event->setEventNews('T');
				$event->setEventAnnouncement('N');
			} elseif ($event_kind == 'Z') {
				$event->setEventNews('N');
				$event->setEventAnnouncement('T');
			}
			
			// Zapisujemy zdjęcia
			$event = $this->_processEventFormPhotos($event, $this->view->form);
			
			/*
			$length = Core_Length::checkLengthPreContent($this->view->form->pre_content_pl->getValue());
			if ($length == -1){
					$this->view->priorityMessenger('Treść zajawki jest zbyt długa (maksymalna liczba znaków - 90)');
					$this->render('edit');
					return;
			}
			*/
			
			
			$mapper->save($event);
			$this->view->priorityMessenger('Zapisano event w bazie danych');
			$this->_helper->redirector->gotoSimple('show', 'event', null, array('id' => $event->getId()));
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			$this->render('edit');
		}
	}


	public function saveEditAction() {
		$this->view->form = $this->_getEditForm();
		$this->view->form->removeElement('file');
		$this->view->form->removeElement('file2');
		$this->view->form->removeElement('file3');
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('edit');
			return;
		}

		//event
		$event = new Application_Model_Event($this->_getAllParams());
		$mapper = new Application_Model_EventMapper();
		try {
			$event->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$event->setUser($this->getLoggedUserName());
			

			$event_kind = $this->view->form->event_kind->getValue();
			if ($event_kind == 'N') {
				$event->setEventNews('T');
				$event->setEventAnnouncement('N');
			} elseif ($event_kind == 'Z') {
				$event->setEventNews('N');
				$event->setEventAnnouncement('T');
			}

			$mapper->save($event);
			$this->view->priorityMessenger('Zapisano event w bazie danych');
			$this->_helper->redirector->gotoSimple('index', 'event', null, array('where' => $this->_getParam('where')));
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			$this->render('edit');
		}
	}

	public function savePhotoAction() {

		$this->view->form = $this->_getPhotoForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('index');
			return;
		}

		$eventId = $this->view->form->eventId->getValue();
		$mapper = new Application_Model_EventMapper();
		$event = $mapper->find($eventId);


		Zend_Db_Table::getDefaultAdapter()->beginTransaction();
		try {
			
			$event = $this->_processEventFormPhotos($event, $this->view->form);
			$mapper->save($event);

			$this->view->priorityMessenger('Zapisano zdjęcia w bazie danych');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy dodawaniu zdjęć: ' . $e->getMessage(), 'error');
			Zend_Db_Table::getDefaultAdapter()->rollBack();
			$this->_helper->redirector->gotoSimple('show', null, null,
					array('id' => $eventId))->redirectAndExit();
		}
		Zend_Db_Table::getDefaultAdapter()->commit();

		$this->_helper->redirector->gotoSimple('show', 'event', null, array('id' => $eventId));
	}

	private function _processEventFormPhotos($event, $form) {
		//zdjecie duze
		$form->id && $id = $form->id->getValue();
		$photo = $this->_savePhoto($id, $form->file);
		if ($photo && $photo->getId()) {
			$event->setPictureId($photo->getId());
			Core_Image::autocrop($this->_getPhotoPath($photo->getName()),
					$this->_getPhotoPath($event->getLargePictureName()),
					array('ratio' => $event->getLargePictureRatio()));

			// Generujemy tylko jeśli event nie ma dedykowanej małej miniaturki
			if (!$event->hasPictureIdSmall()) {
				Core_Image::autocrop($this->_getPhotoPath($photo->getName()),
					$this->_getPhotoPath($event->getSmallPictureName()),
					array('ratio' => $event->getSmallPictureRatio()));
			}

			// Generujemy tylko jeśli event nie ma dedykowanej miniaturki dla archiwum
			if (!$event->hasPictureIdArchive()) {
				Core_Image::autocrop($this->_getPhotoPath($photo->getName()),
					$this->_getPhotoPath($event->getArchivePictureName()),
					array('ratio' => $event->getArchivePictureRatio()));
			}
		}
		//zdjecie male
		$form->idS && $idS = $form->idS->getValue();
		$photo = $this->_savePhoto($idS, $form->file2);
		if ($photo && $photo->getId()) {
			$event->setPictureIdSmall($photo->getId());
			Core_Image::autocrop($this->_getPhotoPath($photo->getName()),
					$this->_getPhotoPath($event->getSmallPictureName()),
					array('ratio' => $event->getSmallPictureRatio()));
		}
		//zdjecie archiwum
		$form->idA && $idA = $form->idA->getValue();
		$photo = $this->_savePhoto($idA, $form->file3);
		if ($photo && $photo->getId()) {
			$event->setPictureIdArchive($photo->getId());
			Core_Image::autocrop($this->_getPhotoPath($photo->getName()),
					$this->_getPhotoPath($event->getArchivePictureName()),
					array('ratio' => $event->getArchivePictureRatio()));
		}
		return $event;
	}

	public function editPhotoAction() {
		$eventId = $this->_getParam('eventId');
		if (!$eventId) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}

		$photoId = $this->_getParam('id');
		if (!$photoId) {
			$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $eventId));
			return;
		}
		
		$event = Core_Model_MapperAbstract::getInstance('Event')->find($eventId);
		
		$this->view->photo = Core_Model_MapperAbstract::getInstance('Photo')->find($photoId);
		$this->view->controller = 'event';
		$this->view->sourceId = $eventId;
		switch ($this->_getParam('type', 'large')) {
			case 'large':
				$this->view->ratio = $event->getLargePictureRatio();
				$this->view->type = 'large';
				break;
			case 'small':
				$this->view->ratio = $event->getSmallPictureRatio();
				$this->view->type = 'small';
				break;
			case 'archive':
				$this->view->ratio = $event->getArchivePictureRatio();
				$this->view->type = 'archive';
				break;
		};
		$this->render('shared/edit-photo', null, true);
	}

	public function cropPhotoAction () {
		$eventId = $this->_getParam('sourceId');
		if (!$eventId) {
			$this->view->priorityMessenger('Brak id eventu', 'error');
			$this->_helper->redirector->gotoSimple('index')->redirectAndExit();
		}
		
		$id = $this->_getParam('id');
		if (!$id) {
			$this->view->priorityMessenger('Brak id zdjęcia do edycji', 'error');
			$this->_redirectToEvent($eventId);
		}
		
		$photo = Core_Model_MapperAbstract::getInstance('Photo')->find($id);
		if (!$photo) {
			$this->view->priorityMessenger('Zdjęcie o podanym id nie istnieje', 'error');
			$this->_redirectToEvent($eventId);
		}
		
		$event = Core_Model_MapperAbstract::getInstance('Event')->find($eventId);
		$crop = $this->_getParam('crop', array());
		foreach ($crop as &$val)
			$val = round($val);
		
		$crop['tw'] = $crop['w'];
		$crop['th'] = $crop['h'];
		$method = "get" . ucfirst($this->_getParam('type', 'large')) . "PictureName";
		Core_Image::crop($this->_getPhotoPath($photo->getName()), 
				$this->_getPhotoPath($event->$method()), $crop);
		
		$this->_redirectToEvent($eventId);
	}

	/**
	 *
	 * @param int $id
	 * @param Zend_Form_Element_File $fileFormElement
	 * @return null|\Application_Model_Photo
	 * @throws Exception 
	 */
	private function _savePhoto($id, $fileFormElement) {
		$fileName = $fileFormElement->getValue();
		if ($fileName == null) {
			return null;
		}

		$mapper = new Application_Model_PhotoMapper();
		if ($mapper->fetchOne(array('name = ?' => "/pictures/$fileName"))) {
			throw new Exception("W katalogu znajduje się już zdjęcie o nazwie $fileName");
		}

		// metoda receive kopiuje już do odpowiedniego katalogu
		// see _getForm()
		if (!$fileFormElement->receive()) {
			throw new Exception("Problem podczas wysyłania pliku $fileName");
		}

		if ($id) {
			$photo = $mapper->find($id);
			$oldPictureName = $photo->getName();
		}

		$photo = new Application_Model_Photo();
		$photo->setName("/pictures/$fileName");
		$photo->setGalleryId(null);
		$photo->setInformation(null);
		$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
		$photo->setUser($this->getLoggedUserName());
		$photo->setId($id ? : null);

		$mapper->save($photo);

		return $photo;
	}

	private function _removePicture($fileName) {
		return unlink(APPLICATION_PATH . "/../public/pictures/$fileName");
	}
	
	private function _getForm() {
		$form = new Admin_Form_Event();
		$form->setAction($this->_helper->url('save'));
		$uploadPath = realpath(APPLICATION_PATH . "/../public/pictures/") . '/';
		$form->file->setDestination($uploadPath);
		$form->file2->setDestination($uploadPath);
		$form->file3->setDestination($uploadPath);
		return $form;
	}

	private function _getEditForm() {
		$form = $this->_getForm();
		$form->setAction($this->_helper->url('save-edit', 'event', null, array('where' => $this->_getParam('where'))));
		return $form;
	}

	private function _getPhotoForm() {
		$form = new Admin_Form_PhotoE();
		$uploadPath = realpath(APPLICATION_PATH . "/../public/pictures/") . '/';
		$form->file->setDestination($uploadPath);
		$form->file2->setDestination($uploadPath);
		$form->file3->setDestination($uploadPath);
		$form->setAction($this->_helper->url('save-photo'));
		return $form;
	}

	private function _redirectToEvent($eventId) {
		$this->_helper->redirector->gotoSimple('show', 'event', null, array('id' => $eventId))
			->redirectAndExit();
	}
	
	private function _getPhotoPath($photoName) {
		return APPLICATION_PATH . "/../public$photoName";
	}
	
	
	public function removePhotoAction() {
		$eventId = $this->_getParam('eventId');
		if (!$eventId) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}

		$photoId = $this->_getParam('id');
		if (!$photoId) {
			$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $eventId));
			return;
		}
		
		$photoKind = $this->_getParam('type', 'large');

		
		//usuwanie zdjecia
		$mapper = new Application_Model_PictureMapper();
		$picture = $mapper->find($photoId);
		$photoName = $picture->getName();
		if ($photoName != NULL) {
				if (!unlink(APPLICATION_PATH . "/../public$photoName")) {
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				} else {
					if (!$mapper->delete($photoId)) {
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else {
						null;//$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}

		//update na evencie
	    $mapper2 = new Application_Model_EventMapper();
		try {
			$event = $mapper2->find($eventId);
			

			if ($photoKind == 'large'){
				$event->setPictureId(0);
			}
			elseif ($photoKind == 'small'){
				$event->setPictureIdSmall(0);
			}
			elseif ($photoKind == 'archive'){
				$event->setPictureIdArchive(0);
			}
				$mapper2->save($event);
		}	
		catch(Exception $e){
			$this->view->priorityMessenger('Błąd przy zdjęcia z eventu eventu');
			$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $eventId));
		}
			
		
		/*
		$event = Core_Model_MapperAbstract::getInstance('Event')->find($eventId);
		
		$this->view->photo = Core_Model_MapperAbstract::getInstance('Photo')->find($photoId);
		$this->view->controller = 'event';
		$this->view->sourceId = $eventId;
		switch ($this->_getParam('type', 'large')) {
			case 'large':
				$this->view->ratio = $event->getLargePictureRatio();
				$this->view->type = 'large';
				break;
			case 'small':
				$this->view->ratio = $event->getSmallPictureRatio();
				$this->view->type = 'small';
				break;
			case 'archive':
				$this->view->ratio = $event->getArchivePictureRatio();
				$this->view->type = 'archive';
				break;
		};
		*/
		$this->_helper->redirector->gotoSimple('show', null, null, array('id' => $eventId));
	}
}

