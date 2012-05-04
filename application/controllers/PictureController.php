<?php

class PictureController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $picture = new Application_Model_PictureMapper();
        $this->view->entries = $picture->fetchAll();
    }


}

