<?php
class Core_Model_MapperAbstract {
	
	protected $_dbTable;
	protected $_modelName;
	public static $modelPrefix = 'Application_Model_';
	
	public function __construct($modelName = null) {
		$this->_modelName = $modelName;
	}

	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Core_Model_DbTable_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}
	
	public function getDbTable() {
		if (null === $this->_dbTable) {
			
			if (!$this->_modelName) {
				$mapperClass = explode('_', get_class($this));
				$this->_modelName = str_replace('Mapper', '', array_pop($mapperClass));
			}
			
			
			$this->setDbTable(self::$modelPrefix . 'DbTable_' . $this->_modelName);
		}
		return $this->_dbTable;
	}
	
	public function save(Core_Model_Abstract $model) {
		try {
			$data = $model->toArray();
			
			$primaryKey = $this->getDbTable()->getPrimary();
			if (null === ($id = $data[$primaryKey])) {
				unset($data[$primaryKey]);
				$this->getDbTable()->insert($data);
			} else {
				$this->getDbTable()->update($data, array("$primaryKey = ?" => $id));
			}
		} catch (Exception $e) {

		}
	}

	public function find($id) {
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$modelClass = self::$modelPrefix . $this->_modelName;
		$model = new $modelClass($row->toArray());
	}

	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
		$entries   = array();
		$modelClass = self::$modelPrefix . $this->_modelName;
		foreach ($resultSet as $row) {
			$entries[] = new $modelClass($row->toArray());
		}
		return $entries;
	}
}