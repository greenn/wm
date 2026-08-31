<?#3.3.1 - page data

trait page_propPik {

	//каждый параметр, превращает в массив
	function propPikAlign($props){
		$_props = array();
		foreach ($props as $prop) {
			if (is_string($prop)) {
				//$containsSlash = strpos($prop, '/') !== false;
				$prop = explode('/', $prop);
			}

			if (is_array($prop) && $prop) {
				$_props []= $prop;
			}
		}
		//$_props = array_unique($_props);
		return $_props;
	}
		function _propPikAlign(&$props){ //01
			$props = $this->propPikAlign($props);
		}

		function propPikAlignChain(/*$prop1, $propN*/){//05
			return 	$this->propPikAlign(func_get_args());
		}

	function propPikAlignBase($base, $propsList){
		$props = $this->propPikAlign($propsList);
		if ($base) {
			foreach ($props as &$chain) {
				array_unshift($chain, $base);
			}
		}
		//dx($props_, $base, $props);
		return $props;
	}

	//получаем первый подходящий параметр из стека $propNames
	function propPik($propNames, $otherwise = null){
		//$this->_propPikAlign($props);
		$propNames = $this->propPikAlign($propNames);

		foreach ($propNames as $tryProp) {
			//d($tryProp);
			if ($this->has_prop($tryProp)) {
				return $this->prop($tryProp);
			}
		}
		return $otherwise;
	}

	//получаем первый подходящий параметр из стека под-имён свойства $base
	function propPikIn($base, $propSubNames, $otherwise = null){
		$propNames = $this->propPikAlignBase($base, $propSubNames);
		//dx($_props, $_props[0], json_encode($_props));
		return $this->propPik($propNames);
	}

	function title($type, $alt = false, $def = 'page'){
		return $this->propPikIn('title', array($type, $alt, $def));
	}
}