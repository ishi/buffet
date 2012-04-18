<?php

// application/models/Event.php

class Application_Model_Event extends Core_Model_Abstract
{
    protected $_params = array('id', 'content_pl', 'content_en', 'title', 'title_en', 
    	'pre_content_pl', 'pre_content_en', 'picture_id', 'event_news',
    	'event_announcement', 'date_from', 'date_to', 'arch_date', 'user');

// funkcja do pobierania tresci newsa w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getContent()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_content_en;
        }
        else{
        	return $this->_content_pl;
        }
    }
    
// funkcja do pobierania zajawki newsa w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getPreContent()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_pre_content_en;
        }
        else{
        	return $this->_pre_content_pl;
        }
    }
    
// funkcja do pobierania tytulu newsa w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getTitleLng()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_title_en;
        }
        else{
        	return $this->_title;
        }
    } 
    
    
}
