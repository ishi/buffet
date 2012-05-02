<?php
/**
 * Plugin odpowiedzialny za zmianę lauoutu w zależności od modułu
 * 
 * Ustawienia pobierane są z konfiguracji aplikacji.
 * @author ishi
 *
 */
class Core_Controller_Plugin_ModuleLayout extends Zend_Layout_Controller_Plugin_Layout {

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$config = $bootstrap->getOption('resources');
		
		if ($config = $this->getModuleConfig($config, $request->getModuleName())) {
			$this->getLayout()->setOptions($config);
		}
	}
	
	private function getModuleConfig($config, $module) {
		if (isset($config['layout']['module'][$module])) {
			return $config['layout']['module'][$module];
		}
	}
}