<?php
/**
 * Description of LangSelector
 *
 * @author Ishi
 */
class Core_Controller_Plugin_LangSelector extends Zend_Controller_Plugin_Abstract {
    /**
     * Called before an action is dispatched by Zend_Controller_Dispatcher.
     *
     * This callback allows for proxy or filter behavior.  By altering the
     * request and resetting its dispatched flag (via
     * {@link Zend_Controller_Request_Abstract::setDispatched() setDispatched(false)}),
     * the current action may be skipped.
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $lang = strtolower($request->getParam('lang'));
        
        if (!in_array($lang, array('pl', 'en'))) {
            $request->setParam('lang', 'pl');
		}
        
        $lang = $request->getParam('lang');
        
        $locale = new Zend_Locale($request->getParam('lang'));
        Zend_Registry::set('Zend_Locale', $locale);
        
        $translate = new Zend_Translate('csv', APPLICATION_PATH . "/configs/lang/$locale.csv" , $locale);
        Zend_Registry::set('Zend_Translate', $translate);
    }


}