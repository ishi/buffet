<?php

class ArchiveController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $archive = new Application_Model_ArchiveMapper();
        $order = 'date_from DESC';
        $entries = $archive->fetchAll("id", $order);
        $entriesTable = array();
        foreach($entries as $key => $entry) {
        	$entriesTable[$key % 3][] = $entry;
        }
        $this->view->entriesTable = $entriesTable;
    }

	public function detailsAction()
    {
    	$news = new Application_Model_ArchiveMapper();
    	$id = $this->_getParam('id', 1);
        $this->view->entries = $news->fetchAll("id=$id", "id");
    }

}

