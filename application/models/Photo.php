<?php

// application/models/Gallery.php

class Application_Model_Photo extends Core_Model_Abstract {
	protected $_params = array('id', 'name', 'information', 'main_picture', 'gallery_id', 'visible', 'arch_date', 'user', 'link');

	public function getCroppedName() {
		return preg_replace('/\.(\w)/', '-s.$1', $this->getName());
	}

	public function getThumbnailName() {
		return preg_replace('/\.(\w)/', '-t.$1', $this->getName());
	}
}
