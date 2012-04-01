<?php 
// application/models/AnnouncementMapper.php

class Application_Model_AnnouncementMapper
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
            $this->setDbTable('Application_Model_DbTable_Announcement');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Announcement $announcement)
    {
    	try {
	        $data = array(
	            'title'   => $announcement->getTitle(),
	            'content_pl' => $announcement->getContentPl(),
	        	'pre_content_pl' => $announcement->getPreContentPl(),
	        	'picture_id' => $announcement->getPictureId(),
	        	'event_news' => $announcement->getEventNews(),
	        	'event_announcement' => $announcement->getEventAnnouncement(),
	        	'picture_name' => $announcement->getPictureName(),
	        	'date_from' => $announcement->getDateFrom(),
	        );
	
	        if (null === ($id = $announcement->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_Announcement $announcement)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $announcement->setId($row->id)
                  ->setTitle($row->title)
                  ->setContentPl($row->content_pl)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPictureId($row->picture_id)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name)
                  ->setDateFrom($row->date_from);
    }

    public function fetchAll($where)
    {
        $resultSet = $this->getDbTable()->fetchAll($where);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Announcement();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setContentPl($row->content_pl)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPictureId($row->picture_id)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name)
                  ->setDateFrom($row->date_from);
            $entries[] = $entry;
        }
        return $entries;
    }
}