<?#0.2.7
d_(2);
function mysql_conf(/*$prop = null, $value = null*/){
	static $conf = array(
		//'set' => false //has|isset|exist|set|is| #[j]
	);
	static $props = array('db_host', 'user_name', 'user_pass', 'db_name');

	$case = func_num_args();
	if ($case === 0) {
		//case: получить полный assoc-конфиг
		return $conf;
	} else if ($case === 1) {
		//case: получение значения

		$prop = func_get_arg(0);
		if ($prop === true) { //eg: mysql_conf(true)
			//case: получить значения в виде order-массива
			$res = array();
			foreach ($props as $name) {
				$res []= mysql_conf($name);
			}
			return $res;
		} else {
			//case: normal case
			return isset($conf[$prop]) ? $conf[$prop] : null;
		}


	} else if ($case === 2) {
		//case: установка/смена значений
		$prop = func_get_arg(0);
		$value = func_get_arg(1);

		if ($prop === true) { //eg: mysql_conf(true, array())
			//case: установка массива данных
			foreach ($value as $key => $item) {
				$name = isset($props[$key]) ? $props[$key] : $key; //для order и assoc вариантов
				$conf[$name] = $item;
			}
		} else {
			//case: normal case
			$conf[$prop] = $value;
			//$conf['set'] = true;
		}
	}
}