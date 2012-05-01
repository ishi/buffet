<?php

// application/models/Event.php

class Application_Model_Event
{
    protected $_content_pl;
    protected $_content_en;
    protected $_title;
    protected $_title_en;
    protected $_id;
    protected $_pre_content_pl;
    protected $_pre_content_en;
    protected $_picture_id;
    protected $_event_news;
    protected $_event_announcement;
    protected $_picture_name;
    protected $_date_from;
    protected $_picture_id_small;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid event property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid event property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setContentPl($text)
    {
        $this->_content_pl = (string) $text;
        return $this;
    }

    public function getContentPl()
    {
    	return $this->_content_pl;
    }
    
	public function setContentEn($text)
    {
        $this->_content_en = (string) $text;
        return $this;
    }

    public function getContentEn()
    {
    	return $this->_content_en;
    }
    
	public function setPreContentPl($text)
    {
        $this->_pre_content_pl = (string) $text;
        return $this;
    }

    public function getPreContentPl()
    {
        	return $this->_pre_content_pl;
    }
	
	public function setPreContentEn($text)
    {
        $this->_pre_content_en = (string) $text;
        return $this;
    }

    public function getPreContentEn()
    {
        	return $this->_pre_content_en;
    }
    
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }
    
    public function setTitleEn($title)
    {
        $this->_title_en = (string) $title;
        return $this;
    }

    public function getTitleEn()
    {
        return $this->_title_en;
    }

       public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }
    
	public function setPictureId($picture_id)
    {
        $this->_picture_id= (int) $picture_id;
        return $this;
    }

    public function getPictureId()
    {
        return $this->_picture_id;
    }
	
    public function setPictureIdSmall($picture_id_small)
    {
        $this->_picture_id_small= (int) $picture_id_small;
        return $this;
    }

    public function getPictureIdSmall()
    {
        return $this->_picture_id_small;
    }
    
	public function setEventNews($text)
    {
        $this->_event_news = (string) $text;
        return $this;
    }

    public function getEventNews()
    {
        return $this->_event_news;
    }
    
	public function setEventAnnouncement($text)
    {
        $this->_event_announcement = (string) $text;
        return $this;
    }

    public function getEventAnnouncement()
    {
        return $this->_event_announcement;
    }
    
	public function setPictureName($text)
    {
        $this->_picture_name = (string) $text;
        return $this;
    }

    public function getPictureName()
    {
        return $this->_picture_name;
    }
    
	public function setDateFrom($text)
    {
        $this->_date_from = (string) $text;
        return $this;
    }

    public function getDateFrom()
    {
        return $this->_date_from;
    }

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
