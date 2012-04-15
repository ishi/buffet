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
    
	public function detailsAction()
    {
    	$news = new Application_Model_EventMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id", "id");
    }
    
    public function addAction()
    {
    	$request = $this->getRequest();
        $form    = new Application_Form_Add();
        
        if ($this->getRequest()->isPost()) {
        	$formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $event = new Application_Model_Event($form->getValues());
                $mapper  = new Application_Model_EventMapper();
                $mapper->save($event);
                return $this->_helper->redirector('index');
            }else {
				$form->populate($formData);
			}
        }
 
        $this->view->form = $form;
    }
	

}

