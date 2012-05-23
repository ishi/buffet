<?php
class Core_Model_Abstract {

	protected $_params = array();
	private $_values = array();

	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	public function setOptions(array $options) {
		foreach ($options as $key => $value) {
			if (in_array($key, $this->_params)) {
				$this->$key = $value;
			}
		}
		return $this;
	}
	
	public function toArray() {
		return $this->_values;
	}
	
	public function __call($metchodName, $params) {
		$bool = false;
		$name = $metchodName;
		if ('is' == substr($name, 0, 2)) {
			$name = "_$name";
		}
		$method = substr($name, 0, 3);
		if ('has' == $method || '_is' == $method) {
			$method = 'get';
			$bool = true;
		}
		if ('get' == $method || 'set' == $method) {
			$name = substr($name, 3);
		} else {
			$method = null;
		}
		
		try {
			if ($method) {
				array_unshift($params, strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name)));
				$val = call_user_func_array(array($this, "__$method"), $params);
				return $bool ? (boolean) $val : $val;
			}
		} catch (Exception $e) {
			/* Wyjątek oznacza że nie było parametru więc ostatecznie wyrzucamy wyjątek o braku metody */
		}
		
		throw new BadMethodCallException('Invalid method: ' . get_class($this) . "->$metchodName()");
	}
	
	public function __set($name, $value) {
		if (('mapper' == $name) || !in_array($name, $this->_params)) {
			throw new Exception('Invalid property ' . get_class($this) . "->$name");
		}

		$method = 'set' . $name;
		method_exists($this, $method) ? $this->$method($value) : $this->_set($name, $value);
	}

	public function __get($name) {
		if (('mapper' == $name) || !in_array($name, $this->_params)) {
			throw new Exception('Invalid property ' . get_class($this) . "->$name");
		}

		$method = 'get' . $name;
		return method_exists($this, $method) ? $this->$method() : $this->_get($name);
	}

	protected function _set($name, $value) {
		$this->_values[$name] = $value;
	}

	protected function _get($name) {
		return isset($this->_values[$name]) ? $this->_values[$name] : null;
	}
}
