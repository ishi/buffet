<?php

class Application_Model_ArchiveMapper extends Core_Model_MapperAbstract {
	public function __construct() {
		$this->_modelName = 'Event';
		$this->setDbTable('Application_Model_DbTable_Archive');
	}
}