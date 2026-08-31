<?#0.6.0 - project man
/*
	$cfg
		db_struct

		proDir
			uv
		sid
			uv
		hostName
			uv

		остальной конфиг передаётся дальше


*/

//dx функция вместо файда pro.php / pro.inc
//function init_pro(){}


_needphp(
	'inc',
	'dataPath',
	'isAssoc'
);

class pro {
	static $cfg = array();

	static function init($cfg, $init, $renewCfg = false){
		//dx($cfg, $init, $renewCfg);

		if ($renewCfg) {
			static::$cfg = $cfg;
		} else {
			static::$cfg = array_replace_recursive(static::$cfg, $cfg);
		}

		//if (_x('dbg')) dx('pro::init', $cfg, $init);

		foreach ($init as $name => $ctx) {
			$method = "static::init_$name";
			if ($ctx && is_callable($method)) {
				//if ($name === 'pro') dx($ctx); //dbg
				$args = $ctx === true ? array() : (isAssoc($ctx) ? array($ctx): (array)$ctx);
				//if (_x('dbg')) d($method, $args);
				call_user_func_array($method, $args);
			}
		}

	}

	static function cfg_get(){
		$prop = func_get_args();
		$cfg = static::$cfg;
		if (count($prop) > 1) {
			return dataPath($prop, $cfg);
		} else {
			return prop($cfg, $prop[0]);
		}
	}


	//oo _/d/iq/cfgPattern.d-gpt-2.php
	static function dataPattern($pattern){
		preg_match_all('/%([a-z-]+)/', $pattern, $matches);
		$search = array();
		$replace = array();

		foreach ($matches[1] as $placeholder) {
			$placeholderPath = array_merge(array('data'), (array)$placeholder);
			$value = call_user_func_array("pro::cfg_get", $placeholderPath);
			//d($value, $placeholder, $placeholderPath);
			if ($value !== null) {
				$search[] = "%$placeholder";
				$replace[] = $value;
			}
		}

		// Производим замену в шаблоне
		$result = str_replace($search, $replace, $pattern);
		return $result;
	}

	static function db_name(){
		$name = static::cfg_get('db', 'db_name');
		if (!$name) $name = static::cfg_get('db_name');
		return $name;
	}

	static function cfg_solve($val){
		$propVal = prop(static::$cfg, $val);
		if (has_prop(static::$cfg, $val)) {
			return static::cfg_solve($propVal);
		}
		return $propVal;
	}

	static function cfg_solve_path($data){
		if (is_array($data)) {
			$chunks = array();
			foreach ($data as $prop) {
				$chunks []= static::cfg_solve($prop);
			}
			$data = join('/', $chunks);
		}
		return $data;
	}

	static function db_struct(){
		if (!static::cfg_get('db_struct')) {
			$path = static::cfg_get('db-struct-path');
			//$path = static::cfg_get('configDir').'/'.static::cfg_get('db-struct-data');
			//dx(static::$cfg, is_file($path), static::cfg_get('db-struct-data'), $path);
			static::$cfg['db_struct'] = include $path;
			//dx($path, is_file($path), static::$cfg['db_struct']);
		}
		//dx(static::$cfg['db_struct']);
		return static::$cfg['db_struct'];
	}

	//ak needpro
	static function init_need($proDir = false){
		if(!$proDir) $proDir = static::$cfg['proDir'];
		//dx($proDir);
		//конфигурация вызовов need_pro - require для локальных (проектных) php-скриптов
		_needphp('need/need_pro');
		need::$pro = $proDir.'/php';
	}

	static function init_uv($uvPath = false){
		///if (is_array($uvPath))

		if (!is_string($uvPath)) {
			$proDir = static::$cfg['proDir'];
			$sid = static::$cfg['sid'];
			$hostName = prop(static::$cfg, 'hostName', hostName);
			//$uvPath = "$proDir/uv/{$sid}[$hostName].uv";
			$uvPath = "$proDir/uv/{$sid}.uv";
		}
		_needphp('uv'); //web/inc/uv.inc
			//web/inc/uv/urlVersion.php:360
			//подключается web/inc/uv/sd/web.uv
		urlVersion::db_connect($uvPath);
		//dx(500, urlVersion::$db_path);
	}

	static function init_bz($cfg){
		_needphp('bz');

		//$list = $cfg; $defType = false;
		//if (isOrdinal($cfg)) list($list, $defType) = $cfg;
		//bz::init($list, $defType);

		$args_ = isOrdinal($cfg) ? $cfg : array($cfg, false);
		call_user_func_array('bz::init', $args_);
	}

	static function init_pro($list = array()/*, $listN*/){
		//if (_x('dbg')) d(func_get_args(), need::$pro);
		//dx($list);
		foreach (func_get_args() as $list) {
			foreach ($list as $name) {
				need_pro($name);
			}
		}
	}

	static function init_db($config = true){
		_needphp(
			'mysql/_mysql.class',
			'mysql/mc.class',
			//'sd/_sd.class' > _sd::init()

			//подключаем для работы с базой на сайте
			'sd'
		);

		if ($config === true) $config = static::cfg_get('db');
		//dx($config, static::cfg_get('db_name'), static::db_name());

		if (!$config) {
			return;
		}

		mc::$mysql = _mysql::connection($config);
		//dx($config, static::db_name(), mc::$mysql, mc::current_db());
		//dx($config, static::db_name(), mc::$mysql, mc::current_db(), mc::last_sql(), mc::error());

		if (!mc::db_current(false)) { //case: нет подключенной базы / это нормально
			if ($dbName = static::db_name()) {
				//case: база данных указана отдельно (было удобно при install, но можно легко отказаться от этого)
				$success = mc::db_select($dbName);
				//if (!$success) d("база '$dbName' не подключена");
				//dx("база '$dbName' подключена", $success ? '(да)' : '(нет)');
				//dx(mc::db_exist($dbName));
			}
		}

		//dx(mc::$mysql);
	}

}