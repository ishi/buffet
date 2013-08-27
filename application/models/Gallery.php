<?php

// application/models/Gallery.php

class Application_Model_Gallery extends Core_Model_Abstract {
	protected $_params = array('id', 'folder_name', 'folder_date', 'folder_content', 'arch_date', 'user');
	/**
	 * @var Application_Model_Photo[]
	 */
	private $_photos;
	private $_activePhotos;

	public function getFolderDate() {
		return date("d.m.Y", strtotime(parent::getFolderDate()));
	}


	public function getPhotos() {
		if (!$this->_photos) {
			$mapper = new Application_Model_PhotoMapper();
			$this->_photos = $mapper->fetchAll(array('gallery_id = ?'=> $this->getId()));
		}
		return $this->_photos;
	}
	
	public function getActivePhotos() {
		if (!$this->_activePhotos) {
			$mapper = new Application_Model_PhotoMapper();
			$this->_activePhotos = $mapper->fetchAll(array('gallery_id = ?'=> $this->getId(), 'visible = ?' => 1));
		}
		return $this->_activePhotos;
	}
	
	public function getMainPhoto() {
		foreach ($this->getPhotos() as $photo) {
			if ($photo->isMainPicture()) return $photo;
		}
		return reset($this->_photos);
	}
}
