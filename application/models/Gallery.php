<?php

// application/models/Gallery.php

class Application_Model_Gallery extends Core_Model_Abstract {
	protected $_params = array('id', 'folder_name', 'folder_date', 'folder_content', 'arch_date', 'user');
	/**
	 * @var Application_Model_Photo[]
	 */
	private $_photos;

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	public function getPhotos() {
		if (!$this->_photos) {
			$mapper = new Application_Model_PhotoMapper();
			$this->_photos = $mapper->fetchAll(array('gallery_id = ?'=> $this->getId()));
		}
		return $this->_photos;
	}
	
	public function getMainPhoto() {
		foreach ($this->_photos as $photo) {
			if ($photo->getMainPicture()) return $photo;
		}
	}
}
