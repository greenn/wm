<?#2.4.5

class iqCore {

	///
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

	var $selfDir;

	protected $directAssignProps = array();
	protected $reassignProps = array();

	var $options = array(); //опции создания (при инициализации)
	var $settings = array(); //подключаемые данные
	var $data = array(); //информационные данные


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

	function defaultConfig(){
		return array();
	}
	// Метод для инициализации свойств
	protected function initProperties($config, $directAssignProps = true, $reassignProps = true) {
		$fullConfig = array_replace($this->defaultConfig(), $config);

		if ($directAssignProps === true) $directAssignProps = $this->directAssignProps;
		if ($reassignProps === true) $reassignProps = $this->reassignProps;

		// Обрабатываем переназначенные свойства
		if (is_array($reassignProps)) foreach ($reassignProps as $propName => $optName) {
			if (isset($fullConfig[$optName])) {
				$this->$propName = $fullConfig[$optName]; // Назначаем свойство с новым именем
			}
		}

		// Обрабатываем свойства для прямого назначения
		///$this->dbg($directAssignProps, false);
		if ($directAssignProps) foreach ($directAssignProps as $propName) {
			if (isset($fullConfig[$propName])) {
				$this->$propName = $fullConfig[$propName]; // Назначаем свойство напрямую
			}
		}

		$this->options = $fullConfig;
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
					return $this->getProp($propName);
					/*if ($this->hasProp($propName)) {
						return $this->getProp($propName);
					} else {
						return $this->getPropIn('options', $propName);
					}*/
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
	public function hasPropIn($stackName, $propName/*{s,a}*/) {
		return isPathExists($this->$stackName, $propName);
	}

	// Метод для получения значения свойства в указанном стеке
	public function getPropIn($stackName, $propName/*{s,a}*/) {
		///$this->dbg(array('$stackName' => $stackName, '$this->$stackName' => $this->$stackName), false);
		return getValueByPath($this->$stackName, $propName);
	}


	function opt(...$args){
		return $this->optGet($args);
	}
	function hasOpt(...$args){
		return $this->optHas($args);
	}
	function optHas($args){
		return $this->hasPropIn('options', $args);
	}
	function optGet($args){
		//if (_x('dd')) dx($args, $this->getPropIn('options', $args));
		return $this->getPropIn('options', $args);
	}
	function getOpt($args, $otherwise = null){
		return $this->optHas($args) ? $this->optGet($args) : $otherwise;
	}

	function set(...$args){
		return $this->setGet($args);
	}
	function hasSet(...$args){
		return $this->setHas($args);
	}
	function setHas($args){
		return $this->hasPropIn('settings', $args);
	}
	function setGet($args){
		return $this->getPropIn('settings', $args);
	}
	
	function data(...$args){
		return $this->dataGet($args);
	}
	function hasData(...$args){
		return $this->dataHas($args);
	}
	function getData() {
		return $this->set('data');
	}
	function dataHas($args){
		return isPathExists($this->getData(), $args);
	}
	function dataGet($args){
		return getValueByPath($this->getData(), $args);
	}

	function dataOpt(...$args){
		return $this->dataOptGet($args);
	}
	function hasDataOpt(...$args){
		return $this->dataOptHas($args);
	}
	function getDataOpt() {
		return $this->set('opt');
	}
	function dataOptHas($args){
		return isPathExists($this->getDataOpt(), $args);
	}
	function dataOptGet($args){
		return getValueByPath($this->getDataOpt(), $args);
	}


	//устанавливает путь в self-свойство
	//$optProp - свойство опции значение
	function initPropPath($selfProp, $defValue, $optProp = true) {

		if ($optProp === true) $optProp = $selfProp;
		$value = $this->opt($optProp);

		if ($value === true) $value = $defValue;
		//d($defValue, $value, is_dir($value), realpath($value), $selfProp);
		if ($value) {
			$this->$selfProp = is_array($value) ? $value[0] : "{$this->selfDir}/$value";
		}
	}






}