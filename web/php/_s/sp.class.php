<?#0.1.2109
/*
	new sp(LOG);
*/
class sp { //session property path
	var $path = array();
	function __construct($path) {
		if (!is_array($path)) $path = func_get_args();
		$this->path = $path;
		if (!_sp(true, $path)) { //case: если такой путь отсутствует
			//step: создаём этот путь
			s::prop_create($path, array());
		}
	}
	function path($subPath){
		return array_merge($this->path, $subPath);
	}

	function reset($defValue = array()){
		_sp($this->path, $defValue);
	}

	function has($path){
		return _sp(true, $this->path($path));
	}
	function get($path = array()){
		return _sp($this->path($path));
	}
	function set($path, $value){
		return _sp($this->path($path), $value);
	}
	function del($path){
		return _sp(null, $this->path($path));
	}

	function push($path, $value){
		return _sp('push', $this->path($path), $value);
	}
	function set_key($path, $key, $value){
		return _sp('push', $this->path($path), $value, $key);
	}
	function merge($path, $value){
		return _sp('merge', $this->path($path), $value);
	}

	function _push($value){
		return _sp('push', $this->path, $value);
	}
	function _set_key($key, $value){
		return _sp('push', $this->path, $value, $key);
	}
}