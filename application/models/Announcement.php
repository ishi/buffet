<?php

// application/models/Announcement.php

class Application_Model_Announcement
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
    protected $_picture_name_small;
    protected $_date_from;
    protected $_date_to;

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
            throw new Exception('Invalid announcement property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid announcement property');
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
    
	public function setDateTo($text)
    {
        $this->_date_to = (string) $text;
        return $this;
    }

    public function getDateTo()
    {
        return $this->_date_to;
    }
    
    // funkcja do pobierania tresci zapowiedzi w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getContent()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_content_en;
        }
        else{
        	return $this->_content_pl;
        }
    }
    
// funkcja do pobierania zajawki zapowiedzi w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getPreContent()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_pre_content_en;
        }
        else{
        	return $this->_pre_content_pl;
        }
    }

// funkcja do pobierania tytulu zapowiedzi w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getTitleLng()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_title_en;
        }
        else{
        	return $this->_title;
        }
    }  
    
	public function setPictureNameSmall($text)
    {
        $this->_picture_name_small = (string) $text;
        return $this;
    }

    public function getPictureNameSmall()
    {
        return $this->_picture_name_small;
    }
    
    //funkcja do wybierania daty od (jak jest podana jedna data) lub zakredu dat (jak są podane obie daty)
    public function getDate()
    {
    	$data_od = date('d.m.Y', strtotime($this->getDateFrom()) );
    	$data_do = strtotime($this->getDateTo());
    	
    	if ($data_do >0){
    		$data_do = date('d.m.Y', strtotime($this->getDateTo()) );
    		$data = $data_od." - ".$data_do;
    	}
    	else{
    		$data = $data_od;
    		
    	}
    	
    	return $data;
    }
}
