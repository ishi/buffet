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
	        	'title_en'   => $archive->getTitleEn(),
	            'content_pl' => $archive->getContentPl(),
	        	'content_en' => $archive->getContentEn(),
	        	'pre_content_pl' => $archive->getPreContentPl(),
	        	'pre_content_en' => $archive->getPreContentEn(),
	        	'picture_id' => $archive->getPictureId(),
	        	'event_news' => $archive->getEventNews(),
	        	'event_announcement' => $archive->getEventAnnouncement(),
	        	'picture_name' => $archive->getPictureName(),
	        	'date_from' => $archive->getDateFrom(),
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
                  ->setTitleEn($row->title_en)
                  ->setContentPl($row->content_pl)
                  ->setContentEn($row->content_en)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPreContentEn($row->pre_content_en)
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
            $entry = new Application_Model_Archive();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setTitleEn($row->title_en)
                  ->setContentPl($row->content_pl)
                  ->setContentEn($row->content_en)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPreContentEn($row->pre_content_en)
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