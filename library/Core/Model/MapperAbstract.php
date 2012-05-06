<?php

class Core_Model_MapperAbstract {

	static private $_instance = array();
	protected $_dbTable;
	protected $_modelName;
	public static $modelPrefix = 'Application_Model_';

	/**
	 * @param string $model
	 * @return Core_Model_MapperAbstract 
	 */
	public static function getInstance($model = null) {
		$class = get_called_class();
		if (!isset(self::$_instance[$class])) {
			self::$_instance[$class] = new $class($model);
		}
		return self::$_instance[$class];
	}
	
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

	public function getModelName() {
		if (!$this->_modelName) {
			$mapperClass = explode('_', get_class($this));
			$this->_modelName = str_replace('Mapper', '', array_pop($mapperClass));
		}
		return $this->_modelName;
	}

	/**
	 * @return Core_Model_DbTable_Abstract 
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
			$this->setDbTable(self::$modelPrefix . 'DbTable_' . $this->getModelName());
		}
		return $this->_dbTable;
	}

	public function save(Core_Model_Abstract $model) {
		$data = $model->toArray();

		$primaryKey = $this->getDbTable()->getPrimary();
		
		
		$id = null;
		if (isset($data[$primaryKey])) {
			$id = $data[$primaryKey];
			unset($data[$primaryKey]);
		}
		
		
		if (!$id) {
			$model->{$primaryKey} = $this->getDbTable()->insert($data);
		} else {
			$this->getDbTable()->update($data, array("$primaryKey = ?" => $id));
		}
	}

	public function delete($id) {
		$primaryKey = $this->getDbTable()->getPrimary();
		return $this->getDbTable()->delete(array("$primaryKey = ?" => $id));
	}

	public function find($id) {
		$resultSet = $this->getDbTable()->find($id);
		if (!$resultSet->count()) {
			return;
		}
		$row = $resultSet->current();
		$modelClass = self::$modelPrefix . $this->getModelName();
		return new $modelClass($row->toArray());
	}

	public function fetchOne($where = null, $order = null, $offset = null) {
		$row = $this->getDbTable()->fetchRow($where, $order, $offset);
		$modelClass = self::$modelPrefix . $this->getModelName();
		return $row ? new $modelClass($row->toArray()) : null;
	}
	
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
		$entries = array();
		$modelClass = self::$modelPrefix . $this->getModelName();
		foreach ($resultSet as $row) {
			$entries[] = new $modelClass($row->toArray());
		}
		return $entries;
	}
}