<?#4.1.1 - new custom class

//d('kot.pro.php+');
//_needphp('str/startsWith');

class proKot extends pro {
	static $cfg = array(); //< init() //своя конфиг

	//db_name() > cfg_get('db', 'db_name') / cfg_get('db_name');
	//db_struct() > cfg_get('db_struct') / cfg_get('db-struct-path')

	//init_need() <  $cfg['proDir']
	//init_uv() <  $cfg['proDir'] + $cfg['sid'] + ?$cfg['hostName']

	static function init_pro($list = array()/*, $listN*/){
		//d(func_get_args());
		foreach (func_get_args() as $list) {
			foreach ($list as $name) {
				need_kot($name);
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

		mcKot::$mysql = _mysql::connection($config);
		//dx($config, static::db_name(), mcKot::$mysql, mcKot::db_current());
		//dx($config, static::db_name(), mcKot::$mysql, mcKot::current_db(), mcKot::last_sql(), mcKot::error());

		if (!mcKot::db_current(false)) { //case: нет подключенной базы
			if ($dbName = static::db_name()) {
				//case: база данных указана отдельно (было удобно при install, но можно легко отказаться от этого)
				$success = mcKot::db_select($dbName);
				//if (!$success) d("база '$dbName' не подключена");
				//d("база '$dbName' не подключена", $success ? '(да)' : '(нет)');
			}
		}

		//dx(mcKot::$mysql);
	}

}

//получение данных из pro
//[ug] proKot('sid')
function proKot(/*cfgProp, cfgSubProp*/){
	return call_user_func_array("proKot::cfg_get", func_get_args());
}

//[eg] _proKot('app-title') ~ pro('data', 'app-title')
function _proKot(/*dataProp, dataSubProp*/){
	$args = func_get_args();
	array_unshift($args, 'data');
	return call_user_func_array("proKot", $args);
}

function need_kot(){
	static $dir = false;
	if (!$dir) $dir = proKot('proDir');
	//dx($dir, func_get_args());
	foreach (func_get_args() as $phpName) {
		need::path($phpName, $dir);
	}
}


class _cssKot extends _css {
	static $db = array(); //своя база
}

function _cssKot($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _cssKot::val($arg);
}


class kot extends rt {
	static $rClass = 'kot';
	
	//01
		static $temp;
		static $vtpl = false;
		static $vdef = 0;
		static $vname = array();

	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		//return $usePrefix ? 'm'.$n : $n;
		return $n;
	}

}

//менеджер по работе с kot классом
class _kot extends _rt {
	static $rClass = 'kot';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/kot/r/app';
	}

	static function className($name){
		return "kot_$name";
	}
}



class kot_i extends _img {
	static $dir = 'kot/img';

	/*static function uri($relName){
		$uri = parent::uri($relName, true);
		return static::$host.$uri;
	}*/

}


function kot($name, $method = null/*, $arg1, $arg2*/){
	return _r_('kot', func_get_args());
}

function kot_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	return _r_tpl('kot', func_get_args());
	/*if (is_array($tplName)) {
		//case: kot_tpl($name, $tplCtx)
		$tplCtx = $tplName;
		$tplName = true;
	}
	if ($tplName === true) {
		//case: kot_tpl($name)
		$tplName = $name;
	}
	//d($name, $tplName, $tplCtx, $fileExt);
	return kot($name, $method, $tplName, $tplCtx, $fileExt);*/
}

function kot_tpl_($Args) {
	return call_user_func_array('kot_tpl', (array)$Args);
}

function kot_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return kot_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}

/*
	ug
		api_kot('side-menu/list', array('by' => 'link'))
	    api_kot('targets/list')
	    kot_api::get_prop('list', 'targets/list')
*/
function api_kot(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'kot');
}


class kot_api extends _api {
	static $r = 'kot';

	//свои настройки
	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}


class mcKot extends mc {
	static $mysql; //своё подключение
}

//q still
class dbsKot extends dbs {
	static $struct = array();
}
