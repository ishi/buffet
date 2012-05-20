<?php

class Admin_EventController extends Zend_Controller_Action
{
	public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    	$_SESSION['event_kind'] = $this->_getParam('where', 'news');
    	if(!isset($_SESSION['event_kind'])) $_SESSION['event_kind'] = $this->_getParam('where', 'news');
    }
    
    public function indexAction()
    {
    	$event = new Application_Model_EventMapper();
        
    	$param = $this->_getParam('where', 'news');
        if($param=='news'){
        	$where = 'event_news = \'T\'';
        }
        elseif ($param=='announcement'){
        	$where = 'event_announcement = \'T\' and ((
										date_to IS NOT NULL AND date_format(date_to, \'%Y-%m-%d\') >= date_format(now(), \'%Y-%m-%d\')
										)
										OR (
										date_to IS NULL AND date_format(date_from, \'%Y-%m-%d\') >= date_format(now(), \'%Y-%m-%d\')))';
        }
    	elseif ($param=='archive'){
        	$where = 'event_announcement = \'T\' and ((
										date_format(date_to, \'%Y-%m-%d\') IS NOT NULL AND date_format(date_to, \'%Y-%m-%d\') < date_format(now(), \'%Y-%m-%d\')
										)
										OR (
										date_format(date_to, \'%Y-%m-%d\') IS NULL AND date_format(date_from, \'%Y-%m-%d\') < date_format(now(), \'%Y-%m-%d\')))';
        }
        else{
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
		$pictId =  $this->view->event->getPictureId();
		$pictIdSmall =  $this->view->event->getPictureIdSmall();
		$pictIdArchive =  $this->view->event->getPictureIdArchive();
		//$_SESSION['pict_id'] = $pictId;
		//$_SESSION['pict_id_small'] = $pictIdSmall;
		//$_SESSION['event_id'] = $id;
		
		$picture = new Application_Model_PictureMapper();
		$where = null;
		
		if ($pictId == null){
			$pictIdF = -1;
		}
		else{
			$pictIdF = $pictId;
		}
		
		if ($pictIdSmall == null){
			$pictIdSmallF = -1;
		}
		else{
			$pictIdSmallF = $pictIdSmall;
		}
		
		if ($pictIdArchive == null){
			$pictIdArchiveF = -1;
		}
		else{
			$pictIdArchiveF = $pictIdArchive;
		}
		$where = "id IN (".$pictIdF.", ".$pictIdSmallF.", ".$pictIdArchiveF.")";
		
		/*
		if ($pictId != null){
			$where = "id IN(".$pictId;
			if ($pictIdSmall != null){
				$where .= ", ".$pictIdSmall.")";
			}
			else{
				$where .= ")";
			}
		}
		else{
			if ($pictIdSmall != null){
				$where = "id IN (".$pictIdSmall.")";
			} 
		}
		*/
		
		if ($where != null){
        	$this->view->entries = $picture->fetchAll($where);
		}else{
			$this->view->entries = array();
		}	
        
        $this->view->form = $this->_getPhotoForm();
		//$galleryId = null;
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
		if ($event_news == 'T'){
			$this->view->form->event_kind->setValue('N');
		}
		elseif ($event_announcement == 'T'){
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
		if ($picture_id){
			$mapper2 = new Application_Model_PictureMapper();
			$picture = $mapper2->find($picture_id);
			$picture_name = $picture->getName();
			
			if ($picture_name != NULL){
				if (!unlink(APPLICATION_PATH . "/../public$picture_name")){
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				}
				else{
					if (!$mapper2->delete($picture_id)){
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else{
						null; //$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}
				
		}
		
		
		if ($picture_id_small){
			$mapper3 = new Application_Model_PictureMapper();
			$picture3 = $mapper3->find($picture_id_small);
			$picture_name_small=$picture3->getName();
			if ($picture_name_small != NULL){
				if (!unlink(APPLICATION_PATH . "/../public$picture_name_small")){
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				}
				else{
					if (!$mapper3->delete($picture_id_small)) {
						$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu');
					} else {
						null; //$this->view->priorityMessenger('Usunięto zdjęcie eventu z bazy danych');
					}
				}
			}
			
			
		}
		
		if ($picture_id_archive){
			$mapper4 = new Application_Model_PictureMapper();
			$picture4 = $mapper4->find($picture_id_archive);
			$picture_name_archive=$picture4->getName();
			if ($picture_name_archive != NULL){
				if (!unlink(APPLICATION_PATH . "/../public$picture_name_archive")){
					$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
				}
				else{
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
		$id = $this->view->form->picture_id->getValue();
		$idS = $this->view->form->picture_id_small->getValue();
		$idA = $this->view->form->picture_id_archive->getValue();
		
		/*
		if ($this->view->form->event_news->getValue() == 'N'){
			if ($this->view->form->event_announcement->getValue() == 'N'){
				$this->view->priorityMessenger("Należy wybrać rodzaj eventu!");
				$this->render('edit');
				return;
			}
		};
		*/
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		
		if (!$this->view->form->file2->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		
		if (!$this->view->form->file3->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		
		
		
		//zdjecie duze
		$fileName = $this->view->form->file->getValue();
		
		if ($fileName != null){
		
		$mapper2 = new Application_Model_PhotoMapper();
		if ($mapper2->fetchOne(array('name = ?' => "/pictures/$fileName"))) {
			$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileName");
			$this->_helper->redirector->gotoSimple('index', 'event', null);
			return;
		}
		
		$location = $this->view->form->file->getFileName();
		$newLocation = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileName";
		
		if (!copy($location, $newLocation)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $location do $newLocation");
			$this->render('index');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $location do $newLocation");
		
		$photo = new Application_Model_Photo();
		try {
			$photo->setName("/pictures/$fileName");
			$photo->setGalleryId(null);
			$photo->setInformation(null);
			$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photo->setUser('ola');
			if ($id == 0){
				$photo->setId(null);	
			}
			else{
				$photo->setId($id);
			}

			$mapper2->save($photo);
			$picture_id = $photo->getId();
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileName");
			$this->render('index');
		}
		
		}
		
		
		//zdjecie male
		$fileNameS = $this->view->form->file2->getValue();
		
		if ($fileNameS != null){
		
		$mapperS = new Application_Model_PhotoMapper();
		if ($mapperS->fetchOne(array('name = ?' => "/pictures/$fileNameS"))) {
			$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileNameS");
			$this->_helper->redirector->gotoSimple('index', 'event', null);
			return;
		}
		
		$locationS = $this->view->form->file2->getFileName();
		$newLocationS = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileNameS";
		
		if (!copy($locationS, $newLocationS)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $locationS do $newLocationS");
			$this->render('index');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $locationS do $newLocationS");
		
		$photoS = new Application_Model_Photo();
		try {
			$photoS->setName("/pictures/$fileNameS");
			$photoS->setGalleryId(null);
			$photoS->setInformation(null);
			$photoS->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photoS->setUser('ola');
			if ($idS == 0){
				$photo->setId(null);	
			}
			else{
				$photo->setId($idS);
			}

			$mapperS->save($photoS);
			$picture_id_small = $photoS->getId();
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileNameS");
			$this->render('index');
		}
		
		}
		
		
		//zdjecie archiwum
		$fileNameA = $this->view->form->file3->getValue();
		
		if ($fileNameA != null){
		
		$mapperA = new Application_Model_PhotoMapper();
		if ($mapperA->fetchOne(array('name = ?' => "/pictures/$fileNameA"))) {
			$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileNameA");
			$this->_helper->redirector->gotoSimple('index', 'event', null);
			return;
		}
		
		$locationA = $this->view->form->file3->getFileName();
		$newLocationA = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileNameA";
		
		if (!copy($locationA, $newLocationA)) {
			$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $locationA do $newLocationA");
			$this->render('index');
			return;
		}
				
		$this->view->priorityMessenger("Przeniosłem plik z $locationA do $newLocationA");
		
		$photoA = new Application_Model_Photo();
		try {
			$photoA->setName("/pictures/$fileNameA");
			$photoA->setGalleryId(null);
			$photoA->setInformation(null);
			$photoA->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$photoA->setUser('ola');
			if ($idA == 0){
				$photo->setId(null);	
			}
			else{
				$photo->setId($idA);
			}

			$mapperA->save($photoA);
			$picture_id_archive = $photoA->getId();
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileNameA");
			$this->render('index');
		}
		
		}
		
		
		//event
		$event = new Application_Model_Event($this->_getAllParams());
		$mapper = new Application_Model_EventMapper();
		try {
			$event->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$event->setUser('ola');
			$event->setPictureId($picture_id);
			$event->setPictureIdSmall($picture_id_small);
			$event->setPictureIdArchive($picture_id_archive);
			if ($event->getDateTo() == null)
			{
				$event->setDateTo(null);
			};
			
			$event_kind = $this->view->form->event_kind->getValue();
			if ($event_kind == 'N'){
				$event->setEventNews('T');
				$event->setEventAnnouncement('N');
			}
			elseif ($event_kind = 'Z'){
				$event->setEventNews('N');
				$event->setEventAnnouncement('T');
			}
			
			$mapper->save($event);
			$this->view->priorityMessenger('Zapisano event w bazie danych');
			echo $this->_getParam('where');
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
			$event->setUser('ola');
			if ($event->getDateTo() == null)
			{
				$event->setDateTo(null);
			};
			
			$event_kind = $this->view->form->event_kind->getValue();
			if ($event_kind == 'N'){
				$event->setEventNews('T');
				$event->setEventAnnouncement('N');
			}
			elseif ($event_kind = 'Z'){
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
		
		if (!$this->view->form->file->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		
		if (!$this->view->form->file2->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		
		if (!$this->view->form->file3->receive()) {
			$this->view->priorityMessenger('Problem podczas wysyłania pliku');
			$this->render('index');
			return;
		}
		$eventId = $this->view->form->eventId->getValue();
		
		
		//zdjecie duze
		$fileName = $this->view->form->file->getValue();
		
		if ($fileName != null){
			//event	
			$mapper2 = new Application_Model_EventMapper();
			$event = $mapper2->find($eventId);
			$id = $this->view->form->id->getValue();			
			
			$mapper = new Application_Model_PhotoMapper();
			if ($mapper->fetchOne(array('name = ?' => "/pictures/$fileName"))) {
				$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileName");
				$this->_helper->redirector->gotoSimple('index', 'event', null);
				return;
			}
			
			$location = $this->view->form->file->getFileName();
			
			$newLocation = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileName";
			if (!copy($location, $newLocation)) {
				$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $location do $newLocation");
				$this->render('index');
				return;
			}
					
			$this->view->priorityMessenger("Przeniosłem plik z $location do $newLocation");
			
			if ($id != null){
			$photo = $mapper->find($id);
			$picture_name_old = $photo->getName();

			if (!unlink(APPLICATION_PATH . "/../public$picture_name_old")){
				$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
			}
			else{
			try {
				$photo->setName("/pictures/$fileName");
				$photo->setGalleryId(null);
				$photo->setInformation(null);
				$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
				$photo->setUser('ola');
				if ($id){
					$photo->setId($id);
				}
	
				$mapper->save($photo);

				$event->setPictureId($photo->getId());
				//$mapper2->save($event);	
			}catch (Exception $e) {
				$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
						. $e->getMessage());
				unlink(APPLICATION_PATH . "/../public/pictures/$fileName");
				$this->render('index');
				return;
			}	
			}
			}
			else{
				$photo = new Application_Model_Photo();
				try {
					$photo->setName("/pictures/$fileName");
					$photo->setGalleryId(null);
					$photo->setInformation(null);
					$photo->setArchDate(new Zend_Db_Expr('CURDATE()'));
					$photo->setUser('ola');
					if ($id == 0){
						$photo->setId(null);	
					}
					else{
						$photo->setId($id);
					}

			$mapper->save($photo);
			$picture_id = $photo->getId();
			$event->setPictureId($picture_id);
			$mapper2->save($event);	
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileNameA");
			$this->render('index');
		}
			}
		}

		//zdjecie male
		$fileNameS = $this->view->form->file2->getValue();
		
		if ($fileNameS != null){
			//event	
			$mapper2 = new Application_Model_EventMapper();
			$event = $mapper2->find($eventId);
			$idS = $this->view->form->idS->getValue();
				
			$mapperS = new Application_Model_PhotoMapper();
			if ($mapperS->fetchOne(array('name = ?' => "/pictures/$fileNameS"))) {
				$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileNameS");
				$this->_helper->redirector->gotoSimple('index', 'event', null);
				return;
			}
			
			$locationS = $this->view->form->file2->getFileName();
			$newLocationS = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileNameS";
			
			if (!copy($locationS, $newLocationS)) {
				$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $locationS do $newLocationS");
				$this->render('index');
				return;
			}
					
			$this->view->priorityMessenger("Przeniosłem plik z $locationS do $newLocationS");
			
			if ($idS != null){
			$photoS = $mapperS->find($idS);
			$picture_name_small_old = $photoS->getName();

			if (!unlink(APPLICATION_PATH . "/../public$picture_name_small_old")){
				$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
			}
			else{
			try {
				$photoS->setName("/pictures/$fileNameS");
				$photoS->setGalleryId(null);
				$photoS->setInformation(null);
				$photoS->setArchDate(new Zend_Db_Expr('CURDATE()'));
				$photoS->setUser('ola');
				if ($idS){
					$photoS->setId($idS);
				}
	
				$mapperS->save($photoS);
				
				$event->setPictureIdSmall($photoS->getId());
				//$mapper2->save($event);
				//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
			}catch (Exception $e) {
				$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
						. $e->getMessage());
				unlink(APPLICATION_PATH . "/../public/pictures/$fileNameS");
				$this->render('index');
			}
			}
			}
			else{
				$photoS = new Application_Model_Photo();
				try {
					$photoS->setName("/pictures/$fileNameS");
					$photoS->setGalleryId(null);
					$photoS->setInformation(null);
					$photoS->setArchDate(new Zend_Db_Expr('CURDATE()'));
					$photoS->setUser('ola');
					if ($idS == 0){
						$photoS->setId(null);	
					}
					else{
						$photoS->setId($idS);
					}

			$mapperS->save($photoS);
			$picture_id_small = $photoS->getId();
			$event->setPictureIdSmall($picture_id_small);
			$mapper2->save($event);	
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileNameA");
			$this->render('index');
		}
			}			
		}
		
		
		//zdjecie archiwum
		$fileNameA = $this->view->form->file3->getValue();
		
		if ($fileNameA != null){
			//event	
			$mapper2 = new Application_Model_EventMapper();
			$event = $mapper2->find($eventId);
			$idA = $this->view->form->idA->getValue();

			
			$mapperA = new Application_Model_PhotoMapper();
			if ($mapperA->fetchOne(array('name = ?' => "/pictures/$fileNameA"))) {
				$this->view->priorityMessenger("W katalogu znajduje się już zdjęcie o nazwie $fileNameA");
				$this->_helper->redirector->gotoSimple('index', 'event', null);
				return;
			}
			
			$locationA = $this->view->form->file3->getFileName();
			$newLocationA = realpath(APPLICATION_PATH . "/../public/pictures/") . "/$fileNameA";
			
			if (!copy($locationA, $newLocationA)) {
				$this->view->priorityMessenger("Błąd podczas przenoszenia pliku $locationA do $newLocationA");
				$this->render('index');
				return;
			}
					
			$this->view->priorityMessenger("Przeniosłem plik z $locationA do $newLocationA");
			
			if ($idA != null){
			$photoA = $mapperA->find($idA);
			$picture_name_archive_old = $photoA->getName();

			if (!unlink(APPLICATION_PATH . "/../public$picture_name_archive_old")){
				$this->view->priorityMessenger('Błąd przy usuwaniu zdjęcia eventu z dysku');
			}
			else{
			try {
				$photoA->setName("/pictures/$fileNameA");
				$photoA->setGalleryId(null);
				$photoA->setInformation(null);
				$photoA->setArchDate(new Zend_Db_Expr('CURDATE()'));
				$photoA->setUser('ola');
				if ($idA){
					$photoA->setId($idA);
				}
	
				$mapperA->save($photoA);
				
				$event->setPictureIdArchive($photoA->getId());
				//$mapper2->save($event);
				//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
			}catch (Exception $e) {
				$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
						. $e->getMessage());
				unlink(APPLICATION_PATH . "/../public/pictures/$fileNameA");
				$this->render('index');
			}
			}
			}
			else{
				$photoA = new Application_Model_Photo();
				try {
					$photoA->setName("/pictures/$fileNameA");
					$photoA->setGalleryId(null);
					$photoA->setInformation(null);
					$photoA->setArchDate(new Zend_Db_Expr('CURDATE()'));
					$photoA->setUser('ola');
					if ($idA == 0){
						$photoA->setId(null);	
					}
					else{
						$photoA->setId($idA);
					}

			$mapperA->save($photoA);
			$picture_id_archive = $photoA->getId();
			$event->setPictureIdArchive($picture_id_archive);
			$mapper2->save($event);	
			
			//$this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		}catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: '
					. $e->getMessage());
			unlink(APPLICATION_PATH . "/../public/pictures/$fileNameA");
			$this->render('index');
		}
			}
		}
		
	    $this->view->priorityMessenger('Zapisano zdjęcie w bazie danych');
		$this->_helper->redirector->gotoSimple('show', 'event', null, array('id' => $eventId));
	}
	
	
	private function _getForm() {
		$form = new Admin_Form_Event();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	
	private function _getEditForm() {
		$form = new Admin_Form_Event();
		$form->setAction($this->_helper->url('save-edit', 'event', null, array('where' => $this->_getParam('where'))));
		return $form;
	}
	
	
	private function _getPhotoForm() {
		$form = new Admin_Form_PhotoE();
		$form->setAction($this->_helper->url('save-photo'));
		return $form;
	}
	

}

