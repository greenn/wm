<?#0.3.1
class _cssVars {
	var $list = array();
	var $prefix = '';

	function __construct($data, $prefix = '') {
		$this->setPrefix($prefix);
		$this->setList($data);
	}

	function setPrefix($prefix){
		$this->prefix = $prefix;
	}
	function setList($data){
		foreach ($data as $name => $value) {
			$this->set($name, $value);
		}
	}
	function set($name, $value, $unit = false){
		return $this->list[$name] = static::uval($value, $unit);
		//return $this->list[$name] = $unit ? static::uval($value, $unit) : $value;
	}
	function setUnit($name, $unit){
		$this->set($name, $this->_val($name, $unit));
	}


	static function uval($value, $unit = false){
		if ($unit && $value) {
			if (substr($value, -2) !== $unit) {
				$value .= $unit;
			}
		}
		return $value;
	}

	function __set($name, $value){
		return $this->set($name, $value);
	}

	function __toString() {
		$list = array();
		foreach ($this->list as $name => $value) {
			$varName = $this->_name($name);
			$list []= "$varName: $value;";
		}
		return join(newline, $list);
	}


	function __get($name){
		return $this->_val($name);
	}

	function has($name) {
		return array_key_exists($name, $this->list);
	}

	function _name($name) {
		return join('', array('--', $this->prefix, $name));
	}

	function _val($name, $unit = false) {
		$val = null;
		if ($this->has($name)) {
			$val = $this->list[$name];
			if ($unit) $val = static::uval($val, $unit);
		}
		return $val;
	}

	function px($name){
		if ($this->has($name)) {
			$val = $this->_val($name);
			if (substr($val, -2) !== 'px') {
				$val .= 'px';
			}
			return $val;
		}
		return ''; //0px | -1px | $otherwise
	}
	function int($name){
		return (integer) $this->_val($name);
		$val = $this->_val($name);
		return $val ? (integer) $val : 0;
	}

	function _var($name) {
		$res = '';
		if ($this->has($name)) {
			$res = 'var('.$this->_name($name).')';
		}
		return $res;
	}


}

if (0) {

	$cs = new _cssVars(array(
		'cg0' => '#c6d9dc',
		'fs' => 14,
		'pv' => '20px',
		'ph' => 50,
	), 'rb1-', true);

	$cs->br = floor(($cs->int('fs') + $cs->int('pv') + $cs->int('ph')) / 2);
	d($cs->br); //42
	$cs->setUnit('br', 'px');
	dx($cs->br); //42px

	//$cs->set('br', floor(($cs->int('fs') + $cs->int('pv') + $cs->int('ph')) / 2), 'px');
	//dx($cs->br);

	//$cs->br = floor(($cs->int('fs') + $cs->int('pv') + $cs->int('fs')) / 2);
	//dx($cs->px('br'));
	//dx($cs->pv, $cs->int('pv'), $cs->px('pv'));
	//dx($cs.'', $cs->ct, $cs->_var('ct'), $cs->_name('ct'), $cs->_val('ct'));


}