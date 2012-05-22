<?php

class Application_Model_AnnouncementMapper extends Core_Model_MapperAbstract {
	public function __construct() {
		$this->_modelName = 'Event';
		$this->setDbTable('Application_Model_DbTable_Announcement');
	}
}