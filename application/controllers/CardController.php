<?php

class CardController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $information = new Application_Model_InformationMapper();
        $this->view->entries = $information->fetchAll("type='karta'");
        
        $picture = new Application_Model_PictureMapper();
        $this->view->entries2 = $picture->fetchAll("information='karta'");
    }

}

