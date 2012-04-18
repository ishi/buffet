<?php 
// application/models/EventMapper.php

class Application_Model_EventMapper extends Core_Model_MapperAbstract
{
	/*
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
	        	'event_news' => $event->getEventNews(),
	        	'event_announcement' => $event->getEventAnnouncement(),
	        	'date_from' => $event->getDateFrom(),
	        	'date_to' => $event->getDateTo(),
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
	*/
    /*
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
                  ->setEventNews($row->event_news)
                  ->setEventAnnouncement($row->event_announcement)
                  ->setDateFrom($row->date_from);
    }
	*/
	
//    public function fetchAll($where, $order)
//    {
//        $resultSet = $this->getDbTable()->fetchAll($where, $order);
//        $entries   = array();
//        foreach ($resultSet as $row) {
//            $entry = new Application_Model_Event();
//            $entry->setId($row->id)
//                  ->setTitle($row->title)
//                  ->setTitleEn($row->title_en)
//                  ->setContentPl($row->content_pl)
//                  ->setContentEn($row->content_en)
//                  ->setPreContentPl($row->pre_content_pl)
//                  ->setPreContentEn($row->pre_content_en)
//                  ->setPictureId($row->picture_id)
//                  ->setEventNews($row->event_news)
//                  ->setEventAnnouncement($row->event_announcement)
//                  ->setDateFrom($row->date_from);
//            $entries[] = $entry;
//        }
//        return $entries;
//    }
    
}