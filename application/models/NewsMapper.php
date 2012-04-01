<?php 
// application/models/NewsMapper.php

class Application_Model_NewsMapper
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
            $this->setDbTable('Application_Model_DbTable_News');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_News $news)
    {
    	try {
	        $data = array(
	            'title'   => $news->getTitle(),
	            'content_pl' => $news->getContentPl(),
	        	'pre_content_pl' => $news->getPreContentPl(),
	        	'picture_id' => $news->getPictureId(),
	        	'event_news' => $news->getEventNews(),
	        	'event_announcement' => $news->getEventAnnouncement(),
	        	'picture_name' => $news->getPictureName(),
	        	'date_from' => $news->getDateFrom(),
	        );
	
	        if (null === ($id = $news->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_News $news)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $news->setId($row->id)
                  ->setTitle($row->title)
                  ->setContentPl($row->content_pl)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPictureId($row->picture_id)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name)
                  ->setDateFrom($row->date_from);
    }

    public function fetchAll($where, $order)
    {
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_News();
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