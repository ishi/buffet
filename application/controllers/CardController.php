<?php

class CardController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $information = new Application_Model_InformationViewMapper();
        $this->view->entries = $information->fetchAll("type='karta'");
    }

}

