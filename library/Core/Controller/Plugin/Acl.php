<?php
class Core_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$module = $request->getModuleName();
		if ('admin' != $module) {
			return;
		}
		
		$controller = $request->getControllerName();
		if (!Zend_Auth::getInstance()->hasIdentity()) {
            // If they aren't, they can't logout, so that action should 
            // redirect to the login form
			if ('auth' != $controller) {
				$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
				$redirector->gotoSimple('index', 'auth', 'admin', 
							array('back' => base64_encode($request->getRequestUri()))
						);
				$redirector->redirectAndExit();
			}
        }
	}
}
?>
