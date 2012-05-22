<?php

class Application_Model_NewsMapper extends Core_Model_MapperAbstract {
	public function __construct() {
		$this->_modelName = 'Event';
		$this->setDbTable('Application_Model_DbTable_News');
	}
}