<?php

// application/models/Gallery.php

class Application_Model_Photo extends Core_Model_Abstract {
	protected $_params = array('id', 'name', 'information', 'main_picture', 'gallery_id', 'visible', 'arch_date', 'user', 'link');
}
