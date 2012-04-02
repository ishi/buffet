<?php

class Application_Model_DbTable_Photo extends Core_Model_DbTable_Abstract {
	protected $_name = 'picture';
	protected $_primary = 'id';

	protected $_referenceMap    = array(
		'Gallery' => array(
			'columns'           => array('gallery_id'),
			'refTableClass'     => 'Application_Model_DbTable_Gallery',
			'refColumns'        => array('id'))
	);
}

