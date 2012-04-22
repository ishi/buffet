<?php
class Core_Model_DbTable_Abstract extends Zend_Db_Table_Abstract {
	public function getPrimary() {
		$pk = (array) $this->_primary;
		return reset($pk);
	}
}