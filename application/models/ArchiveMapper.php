<?php 
// application/models/ArchiveMapper.php

class Application_Model_ArchiveMapper
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
            $this->setDbTable('Application_Model_DbTable_Archive');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Archive $archive)
    {
    	try {
	        $data = array(
	            'title'   => $archive->getTitle(),
	            'content_pl' => $archive->getContentPl(),
	        	'pre_content_pl' => $archive->getPreContentPl(),
	        	'picture_id' => $archive->getPictureId(),
	        	'event_news' => $archive->getEventNews(),
	        	'event_announcement' => $archive->getEventAnnouncement(),
	        	'picture_name' => $archive->getPictureName(),
	        );
	
	        if (null === ($id = $archive->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_Archive $archive)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $archive->setId($row->id)
                  ->setTitle($row->title)
                  ->setContentPl($row->content_pl)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPictureId($row->picture_id)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name);
    }

    public function fetchAll($where)
    {
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Archive();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setContentPl($row->content_pl)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPictureId($row->picture_id)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name);
            $entries[] = $entry;
        }
        return $entries;
    }
}