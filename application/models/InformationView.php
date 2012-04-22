<?php

// application/models/InformationView.php

class Application_Model_InformationView
{
    protected $_content;
    protected $_content_en;
    protected $_id;
    protected $_picture_name;

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
            throw new Exception('Invalid information property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid information property');
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

    public function setContent($text)
    {
        $this->_content = (string) $text;
        return $this;
    }

    public function getContent()
    {
        return $this->_content;
    }
    
	public function setContentEn($text)
    {
        $this->_content_en = (string) $text;
        return $this;
    }

    public function getContentEn()
    {
        return $this->_contentEn;
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
    
	public function setPictureName($text)
    {
        $this->_picture_name = (string) $text;
        return $this;
    }

    public function getPictureName()
    {
        return $this->_picture_name;
    }
    
// funkcja do pobierania tresci informacji w zaleznosci od tego czy jest menu polskie czy angielskie
	public function getContentLng()
    {
    	if ($_SESSION['lang']=='en'){
        	return $this->_content_en;
        }
        else{
        	return $this->_content;
        }
    }
}
