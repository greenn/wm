<?#1.4.3

class iqCore {

	static function dbg($data, $exit = true, $raw = false) {
		echo '<pre>',
		$raw ? $data: var_export($data),
		'</pre>';
		if ($exit) exit;
	}

	static function dbgPath($path, $exit = true){
		static::dbg($path, array(
			'path' => $path,
			'is_file' => is_file($path),
		), $exit);
	}


	protected $directAssignProps = array();
	protected $reassignProps = array();
	protected $defPropStack = 'options';


	var $options = array(); //опции создания (при инициализации)
	var $settings = array(); //подключаемые данные

	function updateSettings($data){
		if (is_array($data)) {
			$this->settings = array_replace($this->settings, $data);
		}
	}
	function useSettingsPath($path){
		if (is_file($path)) {
			$data = include $path;
			$this->updateSettings($data);
		}
	}

	// Метод для инициализации свойств
	protected function initProperties($config, $nameOfStack = true, $directAssignProps = true, $reassignProps = true) {
		if ($nameOfStack === true) $nameOfStack = $this->defPropStack;
		if ($directAssignProps === true) $directAssignProps = $this->directAssignProps;
		if ($reassignProps === true) $reassignProps = $this->reassignProps;

		// Обрабатываем переназначенные свойства
		if (is_array($reassignProps)) foreach ($reassignProps as $propName => $optName) {
			if (isset($config[$optName])) {
				$this->$propName = $config[$optName]; // Назначаем свойство с новым именем
			}
		}

		// Обрабатываем свойства для прямого назначения
		if ($directAssignProps) foreach ($directAssignProps as $propName) {
			if (isset($config[$propName])) {
				$this->$propName = $config[$propName]; // Назначаем свойство напрямую
			}
		}

		if ($nameOfStack) {
			$this->$nameOfStack = $config;
		}
	}

	//базовый вызов метода или получение данных от текущего объекта
	function callArgs($args){
		//dx('callArgs', $args, static::class);
		switch (count($args)) {
			case 0: {
				//dx('case-0', $this);
				return $this;
			}
			case 1: {
				$propName = $args[0];
				//dx($propName, $this->hasMethod($propName), $this->hasProp($propName));
				if ($this->hasMethod($propName)) {
					return $this->callMethod($propName, array_slice($args, 1));
				} else {
					if ($this->hasProp($propName) || !$this->defPropStack) {
						return $this->getProp($propName);
					} else {
						return $this->getPropIn($this->defPropStack, $propName);
					}
				}
			}
			default: {
				$methodName = $args[0];
				return $this->callMethod($methodName, array_slice($args, 1));
			}
		}
	}

	// Проверяет наличие свойства у объекта
	//ak function __isset($propName) {}
	function hasProp($propName) {
		return isset($this->$propName);
	}

	// Получает значение свойства
	//ak function __get($propName) {}
	function getProp($propName) {
		if ($this->hasProp($propName)) {
			return $this->$propName;
		}
		return null;
	}

		function getPropPath($dataType, $dataArgs){

			return dataPath($prop, $cfg);

			$prop = func_get_args();
			if (count($prop) > 1) {
				return dataPath($prop, $cfg);
			} else {
				return prop($cfg, $prop[0]);
			}

		}

	// Проверяет наличие метода
	function hasMethod($methodName) {
		return method_exists($this, $methodName);
	}

	// Вызывает метод с аргументами
	function callMethod($methodName, $args = array()) {
		if ($this->hasMethod($methodName)) {
			return call_user_func_array(array($this, $methodName), $args);
		}
		return null;
		//throw new \Exception("Method '$methodName' not found");
	}


	// Метод для проверки существования свойства в указанном стеке
	public function hasPropIn($stackName, $propName) {
		if ($this->hasProp($stackName)) {
			return array_key_exists($propName, $this->$stackName);
		}
		return null;
	}

	// Метод для получения значения свойства в указанном стеке
	public function getPropIn($stackName, $propName) {
		if ($this->hasPropIn($stackName, $propName)) {
			return $this->$stackName[$propName];
		}
		return null;
	}


	function opt($optName){
		return $this->getPropIn('options', $optName);
	}

	//для примера
	function getData(){
		return $this->getProp('data');
	}

	function dataHas(...$args){
		return $this->dataHas_($args);
	}
	function dataHas_($args){
		return isPathExists($this->getData(), $args);
	}

	function data(...$args){
		return $this->data_($args);
	}
	function data_($args){
		return getValueByPath($this->getData(), $args);
	}

}