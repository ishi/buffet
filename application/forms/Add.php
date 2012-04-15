<?php
// application/modules/forms/Guestbook.php
      class Application_Form_Add extends Zend_Form
      {
      public function init()
          {
              // Set the method for the display form to POST
              $this->setMethod('post');

              // Add an email element
              $this->addElement('text', 'title', array(
                  'label'      => 'Tytuł:',
                  'required'   => true,
                  'filters'    => array('StringTrim')
                  //'validators' => array(
                      //'EmailAddress',
                  //)
              ));
              
              $this->addElement('text', 'event_news', array(
                  'label'      => 'event_news:',
                  'required'   => true,
                  'filters'    => array('StringTrim')
                  //'validators' => array(
                      //'EmailAddress',
                  //)
              ));
              
              // Add an date_from element
              /*
              $this->addElement('text', 'date_from', array(
                  'label'      => 'data od:',
                  'required'   => true,
                  'filters'    => array('StringTrim')
                  //'validators' => array(
                      //'EmailAddress',
                  //)
              ));
              */

              // Add the comment element
              $this->addElement('textarea', 'content_pl', array(
                  'label'      => 'Treść pl:',
                  'required'   => true,
                  'validators' => array(
                      array('validator' => 'StringLength', 'options' => array(0, 2000))
                      )
              ));

              // Add a captcha
              /*
              $this->addElement('captcha', 'captcha', array(
                  'label'      => 'Please enter the 5 letters displayed below:',
                  'required'   => true,
                  'captcha'    => array(
                      'captcha' => 'Figlet',
                      'wordLen' => 5,
                      'timeout' => 300
                  )
              ));
              */

              // Add the submit button
              $this->addElement('submit', 'submit', array(
                  'ignore'   => true,
                  'label'    => 'Zapisz',
              ));
              
              // And finally add some CSRF protection
              $this->addElement('hash', 'csrf', array(
                  'ignore' => true,
              ));
          }
      }