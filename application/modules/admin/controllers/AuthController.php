<?php

class Admin_AuthController extends Zend_Controller_Action {

	protected function getLoginForm() {
		$form = new Admin_Form_Login(); 
		$form->setAction(
			$this->_helper->url(
				'process',
				'auth'
			)
		); 
		$from = $this->_request->getParam('back');
		if(!empty($from)) {
			$form->getElement('back')->setValue($from);
		}
		return $form; 
	}
	
	public function indexAction() {
		$this->view->form = $this->getLoginForm();
		$this->_helper->layout->setLayout('layout-login');
	}

	public function processAction() {
		$request = $this->getRequest();

		// Check if we have a POST request
		if (!$request->isPost()) {
			return $this->_helper->redirector->gotoUrl('/admin/');
		}
		
		$form = $this->getLoginForm();
		if ($form->isValid($_POST)) {
			// setup Zend_Auth adapter for a database table 
			$adapter = $this->getAuthAdapter($form->getValues());
			
			// do the authentication
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($adapter); 
			if ($result->isValid()) { 
				// success: store database row to auth's storage 
				// system. (Not the password though!) 
				$data = $adapter->getResultRowObject(null, 'password'); 
				
				$auth->getStorage()->write($data); 
				
				$back = $this->_request->getPost('back');
				$this->_helper->redirector->gotoUrl($back ? base64_decode($back) : '/admin/')
					->redirectAndExit();
			} else { 
				switch ($result->getCode()) {
					case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
						$form->getElement('username')->addError('User doesn\'t exists');
						break;
					case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
						$form->getElement('password')->addError('Wrong password');
						break;
					default:
						$form->addError('Błąd logowania.');
						break;
				}
			}
		}
		$this->view->form = $form;
		$this->render('index');
		$this->_helper->layout->setLayout('layout-login');
	}
	
	public function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->redirector->gotoSimple('index'); // back main page
	}
	
	public function getAuthAdapter(array $params) {
		$authAdapter = new Zend_Auth_Adapter_DbTable(
				Zend_Db_Table::getDefaultAdapter(),
				'user',
				'username',
				'password',
				'sha1(?)'); 
		// collect the data from the user 
		$f = new Zend_Filter_StripTags(); 
		$username = $f->filter($params['username']);
		$password = $f->filter($params['password']); 
		
		// Set the input credential values to authenticate against 
		$authAdapter->setIdentity($username); 
		$authAdapter->setCredential($password);
		return $authAdapter;
    }
}

