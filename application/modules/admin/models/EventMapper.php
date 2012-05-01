<?php 
// application/models/EventMapper.php

class Application_Model_EventMapper
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
            $this->setDbTable('Application_Model_DbTable_Event');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Event $event)
    {
    	try {
	        $data = array(
	            'title'   => $event->getTitle(),
	        	'title_en'   => $event->getTitleEn(),
	            'content_pl' => $event->getContentPl(),
	        	'content_en' => $event->getContentEn(),
	        	'pre_content_pl' => $event->getPreContentPl(),
	        	'pre_content_en' => $event->getPreContentEn(),
	        	'picture_id' => $event->getPictureId(),
	        	'picture_id_small' => $event->getPictureIdSmall(),
	        	'event_news' => $event->getEventNews(),
	        	'event_announcement' => $event->getEventAnnouncement(),
	        	'picture_name' => $event->getPictureName(),
	        	'picture_name_small' => $event->getPictureNameSmall(),
	        	'date_from' => $event->getDateFrom(),
	        );
	
	        if (null === ($id = $event->getId())) {
	            unset($data['id']);
	            $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('id = ?' => $id));
	        }
    	} catch (Exception $e) {
    		
    	}
    }

    public function find($id, Application_Model_Event $event)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $event->setId($row->id)
                  ->setTitle($row->title)
                  ->setTitleEn($row->title_en)
                  ->setContentPl($row->content_pl)
                  ->setContentEn($row->content_en)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPreContentEn($row->pre_content_en)
                  ->setPictureId($row->picture_id)
                  ->setPictureIdSmall($row->picture_id_small)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name)
                  ->setPictureNameSmall($row->picture_name_small)
                  ->setDateFrom($row->date_from);
    }

    public function fetchAll($where, $order)
    {
        $resultSet = $this->getDbTable()->fetchAll($where, $order);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Event();
            $entry->setId($row->id)
                  ->setTitle($row->title)
                  ->setTitleEn($row->title_en)
                  ->setContentPl($row->content_pl)
                  ->setContentEn($row->content_en)
                  ->setPreContentPl($row->pre_content_pl)
                  ->setPreContentEn($row->pre_content_en)
                  ->setPictureId($row->picture_id)
                  ->setPictureIdSmall($row->picture_id_small)
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setPictureName($row->picture_name)
                  ->setPictureNameSmall($row->picture_name_small)
                  ->setDateFrom($row->date_from);
            $entries[] = $entry;
        }
        return $entries;
    }
}