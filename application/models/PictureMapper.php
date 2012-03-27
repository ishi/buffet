<?php 
// application/models/PictureMapper.php

class Application_Model_PictureMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Picture');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Picture $picture)
    {
    	try {
	        $data = array(
	            'name'   => $picture->getName(),
	        );
	
	        if (null === ($id = $picture->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_Picture $picture)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $picture->setId($row->id)
                  ->setName($row->name);
    }

    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Picture();
            $entry->setId($row->id)
                  ->setName($row->name);
            $entries[] = $entry;
        }
        return $entries;
    }
}