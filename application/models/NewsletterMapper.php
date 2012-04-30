<?php 
// application/models/NewsletterMapper.php

class Application_Model_NewsletterMapper extends Core_Model_MapperAbstract
{
	/*
    public function save(Application_Model_Newsletter $newsletter)
    {
    	try {
	        $data = array(
	            'email'   => $newsletter->getEmail(),
	        	'potwierdzenie'   => $newsletter->getPotwierdzenie(),
	            'arch_date' => $newsletter->getArchDate(),
	        	'user' => $newsletter->getUser(),
	        );
	
	        if (null === ($id = $newsletter->getId())) {
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