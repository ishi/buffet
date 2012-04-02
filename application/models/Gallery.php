<?php

// application/models/Gallery.php

class Application_Model_Gallery extends Core_Model_Abstract {
	protected $_params = array('id', 'folder_name', 'folder_date', 'folder_content', 'arch_date', 'user');

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	public function getPhotos() {
		$mapper = new Application_Model_PhotoMapper();
		return $mapper->fetchAll(array('gallery_id = ?'=> $this->getId()),
			array('main_picture DESC', 'id'));
	}
}
