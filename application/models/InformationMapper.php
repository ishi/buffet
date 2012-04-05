<?php 
// application/models/InformationMapper.php

class Application_Model_InformationMapper
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
            $this->setDbTable('Application_Model_DbTable_Information');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Information $information)
    {
    	try {
	        $data = array(
	            'content' => $information->getContent(),
	        	'content_en' => $information->getContentEn(),
	        	'picture_name' => $information->getPictureName(),
	        );
	
	        if (null === ($id = $information->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_Information $information)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $information->setId($row->id)
                  ->setContent($row->content)
                  ->setContentEn($row->content_en)
                  ->setPictureName($row->picture_name);
    }

    public function fetchAll($where)
    {
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Information();
            $entry->setId($row->id)
                  ->setContent($row->content)
                  ->setContentEn($row->content_en)
                  ->setPictureName($row->picture_name);
            $entries[] = $entry;
        }
        return $entries;
    }
}