<?php

class Admin_EventController extends Zend_Controller_Action
{
	public function init()
    {
    	$this -> _helper->layout()->setLayout("layout_admin");    	
    	if(!isset($_SESSION['event_kind'])) $_SESSION['event_kind'] = $this->_getParam('where', 'news');
    }
    
    public function indexAction()
    {
    	$event = new Application_Model_EventMapper();
        
    	$param = $this->_getParam('where', 'news');
        if($param=='news'){
        	$where = 'event_news = \'T\'';
        }
        elseif ($param=='announcement'){
        	$where = 'event_announcement = \'T\' and ((date_to IS NOT NULL AND date_to >= now()) OR (date_to IS NULL AND date_from >= now()))';
        }
    	elseif ($param=='archive'){
        	$where = 'event_announcement = \'T\' and ((date_to IS NOT NULL AND date_to < now( )) OR (date_to IS NULL AND date_from < now( )))';
        }
        else{
        	$where = 'event_news = \'T\'';
        }
    	$order = 'date_from DESC';
    	
        $this->view->entries = $event->fetchAll($where, $order);

    }
    
	public function addAction() {
		$this->view->form = $this->_getForm();
	}
	
	public function editAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_EventMapper();
		$entry = $mapper->find($id);
		$this->view->form = $this->_getForm();
		$this->view->form->populate($entry->toArray());
	}
	
	public function removeAction() {
		if (!($id = $this->_getParam('id'))) {
			$this->view->priorityMessenger('Brak id eventu');
			$this->_helper->redirector->gotoSimple('index');
			return;
		}
		$mapper = new Application_Model_EventMapper();
		if (!$mapper->delete($id)) {
			$this->view->priorityMessenger('Błąd przy usuwaniu eventu');
		} else {
			$this->view->priorityMessenger('Usunięto event z bazy danych');
		}
		$this->_helper->redirector->gotoSimple('index');
	}
	
	public function saveAction() {
		$this->view->form = $this->_getForm();
		if (!$this->view->form->isValid($this->_getAllParams())) {
			$this->render('edit');
			return;
		}
		
		$event = new Application_Model_Event($this->_getAllParams());
		$mapper = new Application_Model_EventMapper();
		try {
			$event->setArchDate(new Zend_Db_Expr('CURDATE()'));
			$event->setUser('ola');
			$event->getEventNews();
			$event->getEventAnnouncement();
			$event->getPictureId();
			
			$mapper->save($event);
			$this->view->priorityMessenger('Zapisano event w bazie danych');
			$this->_helper->redirector->gotoSimple('index');
		} catch (Exception $e) {
			$this->view->priorityMessenger('Problemy przy zapisie do bazy: ' 
					. $e->getMessage());
			$this->render('edit');
		}
	}
	
	private function _getForm() {
		$form = new Admin_Form_Event();
		$form->setAction($this->_helper->url('save'));
		return $form;
	}
	

}

