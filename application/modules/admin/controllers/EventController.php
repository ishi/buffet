<?php

class Admin_EventController extends Zend_Controller_Action
{
	public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    }
    
    public function indexAction()
    {
    	$event = new Application_Model_EventMapper();
        
    	$param = $this->_getParam('where', 'news');
        if($param=='news'){
        	$where = 'event_news = \'T\'';
        }
        elseif ($param=='announcement'){
        	$where = 'event_announcement = \'T\' and date_from >= now()';
        }
    	elseif ($param=='archive'){
        	$where = 'event_announcement = \'T\' and date_from < now()';
        }
        else{
        	$where = 'event_news = \'T\'';
        }
    	$order = 'date_from DESC';
    	
        $this->view->entries = $event->fetchAll($where, $order);

    }
    
	

}

