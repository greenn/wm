<?#1.2.2

//dbg
//if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', "::1"))) include_once dirname($_SERVER['DOCUMENT_ROOT']).'/18.web/web/lib/kint/kint.php';

class siteIq {
	var $dbg = !true;
	var $cfg = array(

		'dirRoot' => true, //=== $_SERVER['DOCUMENT_ROOT'],
		'dirConf' => 'site',

		'nameFileSettings' => 'settings.inc', //01
		'patternNameHostSettings' => 'settings/settings[%hostName].inc',

		'nameFileWeb' => 'web/web.inc', //01
		'patternNameHostWeb' => 'web/web[%hostName].inc',

		'nameFileDomains' => 'domains.inc',
	);

	function set_hostNames($hostNames){
		$hostCfg = array();
		foreach ($hostNames as $name => $cfg) {
			if (is_numeric($name)) { //q ak isOrdinal
				$name = $cfg;
				$cfg = true;
			}
			if (!$cfg || $cfg === true) {
				$cfg = array();
			}
			$hostCfg[$name] = $cfg;
		}
		$this->hostNames = $hostCfg;

	}

	///var $ctx = array(); //контекст запуск / опции для внутренних функций (например для pro)

	//подключаем пошагово iq
	function __construct($cfg, $relIq = false){
		$this->cfg['dirRoot'] = $_SERVER['DOCUMENT_ROOT'];
		///$this->ctx = $ctx;
		$this->_cfgUpdate($cfg);
		//dx($this->cfg); ещё нету dx

		$this->__define_hostName(); //hostName, subDomain

		if ($this->cfg('settings')) $this->__connect_settings();
		if ($this->cfg('web')) $this->__connect_web();
		if ($this->cfg('domains')) $this->__connect_domains();
		if ($this->cfg('req')) $this->__connect_req();
		if ($this->cfg('pro')) $this->__connect_pro();
		//_notch('iq-pro');
		if ($cfgCssData = $this->cfg('css')) {
			//if (_x('dbg')) dx($cfgCss);
			if (isAssoc($cfgCssData)) $cfgCssData = array($cfgCssData);
			foreach ((array)$cfgCssData as $cfgCss) {
				$this->__connect_css($cfgCss);
			}
		}

		/// if ($this->cfg('acts')) $this->__connect_css();

		//dx($this->cfg, pro('cdn'));
		if ($this->cfg('init')) $this->__init_cfg(); //ak _connect_init
	}

	function __get($prop){
		return $this->cfg($prop);
	}

	//обновить текущий конфипг данными (путь, {aa})
	function _cfgUpdate($data){
		if (is_string($data)) $data = $this->get_cfg($data);
		$this->_cfgCalc($data);
		krsort($data);
		$this->cfg = $this->cfgMerge($data);
	}

	//использовать файл
	function inc_path($_path, $include_once = false){
		$_cfg = $this->cfg;
		if ($include_once) {
			$data = include_once $_path;
		} else {
			$data = include $_path;
			//d($data, @$Project);
		}
		return $data;
	}

	//получение данные по пути
	function get_cfg($path){
		if (!is_file($path)) $path = ROOT."/$path";
		//пускай падает с ошибкой
		//if (!is_file($path)) return false;
		return $this->inc_path($path);
	}

	//просчитать данные в конфиге
	function _cfgCalc(&$cfg){
		$cfg['dirPro'] = $this->calcPath('dirRoot', 'nameDirPro');
		$cfg['dirIq'] = $this->calcPath('dirRoot', 'nameDirIq');
		$cfg['dirConfig'] = $this->calcPath('dirRoot', 'nameDirConfig');
	}

	//получить сростить конфиг с данными
	function cfgMerge($data){
		return array_replace_recursive($this->cfg, $data);
	}

	//получить свойство из конфинга
	//вариант передать данные по умолчанию или default для массива
	function cfg($prop, $def = null, $type = false){
		$value = $def;
		if (array_key_exists($prop, $this->cfg)) {
			$value = $this->cfg[$prop];

			if ($type === 'pro' && $value === true) $value = array();

			if (is_array($def) && is_array($value)) { //ak _.defaults
				//d($type, $def, $value);
				switch ($type) {
					case 'pro': {
						if (isset($def['pro']) && isset($value['pro'])) {
							$value['pro'] = $this->cfg_merge_pro_pro($value['pro'], $def['pro']);
							unset($def['pro']);
							//dx($value['pro']);
						}
					} break;
				}
				$value = array_merge_recursive($def, $value);
			}
		}
		return $value;
	}

	function cfg_merge_pro_pro($value, $def){
		$_merge = array();
		foreach ($value as $index => $list) {
			//d($index, $list, is_array($list));
			if (is_array($list)) {
				if (isset($def[$index])) {
					$_merge []= array_merge($def[$index], $list);
				} else {
					$_merge []= $list;
				}
			}
		}
		return $_merge;
	}

	//получить конфиг hostNames
	/*
		ug-case array(
			'vmk.nadube.ru',
			'vmk.loc' => '',
			'gildia.loc',
			'gildia.nadube.ru',
			'vmk.nadube.ru',
		)
	*/
	function cfg_hostNames(){
		$hostCfg = array();
		$hostNames = $this->cfg('hostNames', array());
		foreach ($hostNames as $name => $cfg) {
			if (is_numeric($name)) { //q ak isOrdinal
				$name = $cfg;
				$cfg = true;
			}
			if (!$cfg || $cfg === true) {
				$cfg = array();
			}
			$hostCfg[$name] = $cfg;
		}
		return $hostCfg;
	}

	//образовать путь по аргументам (propName, {s})
	function calcPath(/*$prop1, $propN*/){
		$chunks = array();
		foreach (func_get_args() as $prop) {
			//if (is_array($prop)) d($prop);
			$value = $this->cfg($prop, $prop);
			if (is_array($value)) {
				$value = $this->calcPath_($value);
			}
			if ($value) $chunks []= $value;
		}
		return join('/', $chunks);
	}

	function calcPath_($Args){
		if (is_string($Args)) {
			$Args = $this->cfg($Args);
			if (!is_array($Args)) return $Args;
			//dbg
			if (!true) {
				d($Args, $this->cfg);
				foreach ($Args as $prop) {
					d($prop, $this->cfg($prop));
				}
				$path = call_user_func_array(array($this, 'calcPath'), $Args);
				dx($path, is_file($path));
			}
		}
		return call_user_func_array(array($this, 'calcPath'), $Args);
	}

	function __define_hostName(){
		$cfg = $this->cfg('hostNameCfg', array(
			'level' => 2
		));
		$hostList = $this->cfg_hostNames();
		$curHost = $_SERVER['HTTP_HOST'];
		//dbg
			//$curHost = "lk.$curHost";
			//$curHost = "lk.$curHost.2";
			//dx($hostList, $curHost);

		$matchHost = false;
		foreach ($hostList as $hostName => $hostCfg) {
			$match = substr($curHost, -strlen($hostName)) === $hostName;
			if (!1) { echo '~<pre>',
				'$curHost', ': ', var_export($curHost), '<br />',
				'$hostName', ': ', var_export($hostName), '<br />',
				'$match', ': ', var_export($match), '<br />',
			'</pre>'; exit; }

			if ($match) {
				$matchHost = $hostName;
				break;
			}
		}

		if (!$matchHost) {
			$curHostChunks = explode('.', $curHost);
			//d($curHostChunks, $cfg['level']);
			$domainChunks = array_slice($curHostChunks, -$cfg['level']);
			$matchHost = implode('.', $domainChunks);
		}

		$subDomain = substr($curHost, 0, -strlen(".$matchHost"));
		if (!1) { echo '~<pre>',
			'$matchHost', ': ', var_export($matchHost), '<br />',
			'$subDomain', ': ', var_export($subDomain), '<br />',
		'</pre>'; exit; }
		$this->_cfgUpdate(array(
			'hostName' => $matchHost,
			'subDomain' => $subDomain,
		));
		if ($this->dbg) d($this->hostName, $this->subDomain, $cfg);
	}

	function usePatternProp($propName){

		$pattern = $this->cfg($propName);
		$placeholders = array(
			'%hostName' => $this->cfg('hostName')
		);
		//if ($wholeCtx) $placeholders = []; foreach ($this->cfg as $key => $value) $placeholders["%" . $key] = $value;
		//d('usePatternProp', $pattern, $placeholders);
		return strtr($pattern, $placeholders);
	}

	function __connect_settings(){
		$pathSettings = $this->calcPath('dirConfig', 'nameFileSettings'); //01
		if (!is_file($pathSettings)) {
			$subPathSettings = $this->usePatternProp('patternNameHostSettings');
			//echo $subPathSettings; exit;
			$pathSettings = $this->calcPath('dirConfig', $subPathSettings);
		}
		if ($this->dbg) d('settings:', is_file($pathSettings), $pathSettings);
		if (is_file($pathSettings)) {
			$this->_cfgUpdate($pathSettings);
		}
	}

	function __connect_web(){
		$pathWeb = $this->calcPath('dirConfig', 'nameFileWeb'); //01
		//echo '~<pre>', $pathWeb, ': ', var_export(is_file($pathWeb)), '</pre>'; exit;
		if (!is_file($pathWeb)) {
			$subPathWeb = $this->usePatternProp('patternNameHostWeb');

			$pathWeb = $this->calcPath('dirConfig', $subPathWeb);
			if (!1) { echo '~<pre>',
				$subPathWeb, ': ', var_export(is_file($pathWeb)), '</pre>';
			exit; }
		}
		//if ($this->dbg || !1) d('web:', is_file($pathWeb), $pathWeb);
		//echo '~2<pre>', $pathWeb, var_export(is_file($pathWeb)), '</pre>'; exit;
		if (is_file($pathWeb)) {
			$data = $this->inc_path($pathWeb, true); //подключаем Web Framework
			if (is_array($data)) {
				$this->_cfgUpdate($data);
			}
		} else {
			echo 'web framework miss: ', $pathWeb, exit;
		}
		//_needphp('notch'); _notch('iq');
	}

	function __connect_domains(){
		$pathDomains = $this->calcPath('dirConfig', 'nameFileDomains');
		if ($this->dbg) d('domains:', is_file($pathDomains), $pathDomains);
		if (is_file($pathDomains)) $this->inc_path($pathDomains, true);
	}

	function __connect_req(){
		//d($this->cfg('req')); //ak req_once
		$reqList = $this->cfg('req');
		if ($this->dbg) d('req:', is_array($reqList), $reqList);
		if (is_array($reqList)) foreach ($this->cfg('req') as $propDir => $list) {
			if ($this->dbg) d($list);
			foreach ($list as $filename => $opt_once) {
				if (is_string($opt_once)) {
					$filename = $opt_once;
					$opt_once = false;
				}
				$path = $this->calcPath($propDir, $filename);
				//d(is_file($path), $path, $opt_once);
				if (is_file($path)) $this->inc_path($path, $opt_once);
			}
		}
	}

	function pro($method/*, $arg1, $argN*/){
		$proClass = $this->cfg('proClass', 'pro'); //className для Pro # def 'pro' / mb proKot
		if (is_callable("$proClass::$method")) {
			$args = array_slice(func_get_args(), 1);
			//if (_x('dbg')) d($method, $args);
			return call_user_func_array("$proClass::$method", $args);
		} else {
			return $proClass::$$method;
		}
	}

	function __connect_pro(){
		_needphp(
			'fq/_props',
				'fq/_is',
			'gt',
			'prop.class'
		);
		_needphp('pro/pro.class');

		//dx($this->calcPath_('pathDbStruct'));
		$proCfg = $this->cfg + array(
			'proDir' => $this->dirIq,
			'configDir' => $this->dirConfig,
			'hostName' => $this->hostName,
			'db' => $this->db,
			'db_name' => $this->db_name,
			'db_struct' => $this->db_struct,
			'db-struct-path' => $this->calcPath_('pathDbStruct')
		);

		if ($this->dbg) d('pro:', array(
			'db' => $this->db,
			'db_name' => $this->db_name,
			'db_struct' => $this->db_struct,
			'db-struct-path' => $this->calcPath_('pathDbStruct')
		));

		//dx($proCfg, $this->cfg('pro'), $this->cfg('pro_def'));
		$proInit = $this->cfg('pro', $this->cfg('pro_def'), 'pro');
		//if(_x('dbg')) dx($proInit);

		/*if (prop($proInit, 'uv') === true) {}
		if (is_array(prop($proInit, 'uv'))) {
			$proInit['uv'] = $this->calcPath_($proInit['uv']);
		}*/


		$this->pro('init', $proCfg, $proInit);
		if (0) pro::init($proCfg, $proInit); //ak
	}

	function __connect_css($subPath = true){
		if ($subPath === true) {
			$subPath = 'nameFileCss';
		}
		if (is_array($subPath)) {
			$pathCss = $this->calcPath_($subPath);
			//if (_x('dbg')) dx($subPath, $pathCss);
		} else {
			//base case:
			$pathCss = $this->calcPath('dirConfig', $subPath);
		}

		//d($pathCss);

		//if ($this->dbg) d('css:', is_file($pathCss), $pathCss);
		if (is_file($pathCss)) $this->inc_path($pathCss, true);
	}

	function __init_cfg($cfgList = true){
		if ($cfgList === true) $cfgList = $this->cfg('init');

		foreach ($cfgList as $act => $opt) {
			/*case several-args eg
				'cors-origin' => array(t|f, array($arg1, $arg2)),

			*/
			if (!is_array($opt)) $opt = array($opt);
			//d($act, $cfg[$act], $opt);
			if ($opt[0]) {
				$method = array($this, "__init_$act");
				if (is_callable($method)) {
					$args = prop($opt, 1, array());
					$args = (array)$args;
					//d($act, $args);
					call_user_func_array($method, $args);
				}
			}
		}

		//dx($cfgList);
	}

	function __init_cur_iq($iq = true){
		if ($iq === true) $iq = $this;
		set_cur_iq($iq);
	}

	function __init_cors(){
		$corsOirign = pro('cors-origin');
		$corsOirignList = pro('cors-origin-list');
		//d('__init_cors', $corsOirign, $corsOirignList);

		if ($corsOirign) {
			rt('api', 'set_CORS', array(
				'origin' => $corsOirign,
				'origin-list' => $corsOirignList,
				'cookies' => true,
				'methods' => '*',
				//'headers' => true,
			));
		}
	}

	function __init_qp(){
		//if (func_num_args() === 1) rt::$qp = func_get_arg(0); else
		rt::$qp = pro('opt', 'qp');
	}

	//d
	function __init_aos(){
		//dx('__init_aos', func_get_args());
		_rb::req('aos');
		//if (isLocalhost) rb_aos::$OFF = true; //локальное отключение
		aos_set('mirror:false');
	}

	//dd
	function __init_lang(){
		_lang::$otherwiseUsePrefix = pro('opt', 'lang-prefix');
		_lang::$list = pro('lang', 'list');
		_lang::$base = pro('lang', 'base');
	}

	//dd
	function __init_user_v1(){
		need_pro('acc.class');
		_needphp('_s/init');
		_acc::checkout();
	}

	//q
	function __init_cdn(){
		$cdn = pro('cdn');
		if (is_string($cdn)) {
			$cdn = array('base' => $cdn);
		}

		if ($cdn) {
			$jsCdn = _prop::pik($cdn, array('js', 'base'));
			if ($jsCdn) {
				js::$cdn = $jsCdn;
			}
			$cssCdn = _prop::pik($cdn, array('css', 'base'));
			if ($cssCdn) {
				css::$cdn = $cssCdn;
			}
			$fontsCdn = _prop::pik($cdn, array('fonts', 'base'));
			if ($fontsCdn) {
				_css::$localFontsUrl = $fontsCdn.ltrim(_css::$localFontsUrl, '/');
			}
		}
	}
}

#1.2.1-id
//mb mvd pro/php/iq.php в default pro.class.php вместо need = true
function set_cur_iq($iq){
	//$GLOBALS['_IQ_']
	cur_iq(null, $iq);
}

//mb make ak base_iq

function cur_iq($arg1 = false, $arg2 = false){
	static $iq = null;
	$argsNum = func_num_args();

	# cur_iq(null, $iq);
	//spec case: set cur-iq object
	if ($arg1 === null && $argsNum === 2) {
		$iq = $arg2;
		return $iq;
	}

	# $iq = cur_iq(true);
	//spec case: get cur-iq object
	if ($arg1 === true) {
		if ($argsNum > 1) {
			$method = $arg2;
			$args = array_slice(func_get_args(), 2);
			$caller = array($iq, $method);
			//dx(is_callable($caller), $args);
			if (is_callable($caller)) {
				return call_user_func_array($caller, $args);
			}
		}
		return $iq;
	}


	$res = $iq;
	if ($iq) {
		$res = $iq->cfg;
		if (func_num_args()) {
			$arg1 = func_get_arg(0);
			$res = _prop($iq->cfg, $arg1);
		}
	}
	return $res;
}