<?php

// application/models/Gallery.php

class Application_Model_Photo extends Core_Model_Abstract {
	protected $_params = array('id', 'name', 'information', 'main_picture', 'gallery_id', 'arch_date', 'user');

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
}
