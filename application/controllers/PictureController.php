<?php

class PictureController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $picture = new Application_Model_PictureMapper();
        $this->view->entries = $picture->fetchAll();
    }


}

