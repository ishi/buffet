<?php
class Core_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
	public function getPrimary() {
		return $this->_primary;
	}
}