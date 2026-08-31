<?#4.3.11(site) - site resources

_needphp(
	'rw',
	'fq/merge/merge_keys_values',
	'fq/rand_val',
	'fq/str/val2str'
);

//дублёры pro.php:27
need_pro('rt.class');
need_pro('lang.class');

class site extends rt {
	static $rClass = 'site';
	static $temp; //01

	static $vtpl = false;
	static $vdef = 0;
	static $vname = array();


#= extend-update
	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName, false);
		//return $usePrefix ? 'st'.$n : $n;
		return $n;
	}
#\

}

//менеджер по работе с site классом
class _site extends _rt {
	static $rClass = 'site';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT.'/r/site';
	}

	static function className($name){
		return "site_$name";
	}
}


function site($name, $method = null/*, $arg1, $arg2*/){
	return _r_('site', func_get_args());
}

function site_tpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php', $method = 'tpl'){
	//return _r_tpl('site', func_get_args());
	if ($tplName === true) {
		//case: site_tpl($name)
		$tplName = $name;
	}
	$args = array($name, $method, $tplName, $tplCtx, $fileExt);
	if (func_num_args() > 5) {
		//case spec: есть дополнительные аргументы
		$extraArgs = array_slice(func_get_args(), 5);
		$args = array_merge($args, $extraArgs);
	}
	//d('site_tpl', $name, $tplName, $tplCtx, $fileExt, @$extraArgs);
	return call_user_func_array('site', $args);
	//[vp1] return site($name, $method, $tplName, $tplCtx, $fileExt);
}

function site_tpl_($Args) {
	return call_user_func_array('site_tpl', (array)$Args);
}


function site_w($wCtx, $rName, $tplName = true, $tplCtx = false, $mqrCtx = false){
	$content = site_tpl($rName, $tplName, $tplCtx);

	return _site_w($content, $wCtx, $mqrCtx);
}

//считает класс для wrapper
/* eg
	site_w_ns($_ctx['content-w']), site_w_ns($_ctx['content-w'], true, 'site-w')
*/
function site_w_ns($wCtx, $cfgList = true, $baseName = false){
	if (!is_array($wCtx)) $wCtx = array('site-w' => $wCtx); //case: класс для site-w
	static $ncList = array(
		'content-p',
		'site-w',
		'titul-w',
		'content-w' => 'site-w',
		'text-content',
	);

	if ($cfgList === true) $cfgList = $ncList;
	$ns = array();
	///d($cfgList, $wCtx, $baseName);
	foreach ($cfgList as $name => $relName) {
		if (is_number($name)) { //для Ordinal
			$name = $relName;
		}
		$nc = _prop($wCtx, $name, false);
		//d($nc, $name, $relName);
		if ($nc === true) $nc = $baseName ?: $relName;
		$ns []= $nc;
	}
	$ns = attr::vals($ns);

	return $ns;
}

function site_w_mqr($mqrCtx = false){
	$as = ''; //attributes string
	if ($mqrCtx === true) {
		$mqrCtx = 'mqr';
	}
	if ($mqrCtx && is_stringable($mqrCtx)) {
		$mqrCtx = (array)$mqrCtx;
	}
	if (isOrdinal($mqrCtx)) {
		$mqrCtx = array_fill_keys($mqrCtx, false);
	}
	if (!isAssoc($mqrCtx)) {
		return $as;
	}

	static $mqrList = array(
		'mqr',
		'mqrd',
		'mqrc',
		'mqrs',
		'mqrw',
		'mqrk',
		'mqrz',
		'mqrh',
		'mqrl',
	);

	//step: выравниваем смешанный ao-aa-массив
	$mqrCtx0 = $mqrCtx; //dbg
	foreach ($mqrCtx as $name => $value) {
		if (is_numeric($name) && in_array($value, $mqrList)) {
			unset($mqrCtx[$name]);
			$mqrCtx[$value] = false;
		}
	}
	//dx($mqrCtx0, $mqrCtx);

	$ad = array(); //attribute data
	///d($cfgList, $wCtx, $baseName);
	foreach ($mqrList as $aName) {
		$hasValue = _prop::has($mqrCtx, $aName);
		if ($hasValue) {
			$value = $mqrCtx[$aName];
			if (is_array($value)) {
				$items = array();
				if (isOrdinal($value)) {
					$items = $value;
				} else if (isAssoc($value)) {
					foreach ($value as $prop => $val) {
						$val = val2str($val);
						$items [] = "$prop=$val";
					}
				}
				$value = join(';', $items);
			}
			$ad[$aName] = $value;
		}
	}
	$as = attr::as($ad);
	return $as;
}

//wrapper для html
function _site_w($html, $wCtx = true, $mqrCtx = false){
	$ns = site_w_ns($wCtx);
	//d($ns, $wCtx);
	if ($ns) {
		$as = site_w_mqr($mqrCtx);
		$html = join(newline, array(
			"<div $as class=\"$ns\">",
				$html,
			'</div>',
		));
	}
	return $html;
}



function site_vtpl($name, $tplName = true, $tplCtx = false, $fileExt = 'tpl.php'){
	return site_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}

function site_tplv($name, $tplName = true, $v = false, $tplCtx = false, $fileExt = 'tpl.php'){
	if ($v) $tplName = array($tplName, $v);
	return site_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl');
}
function site_tplvi($name, $tplName = true, $v = false, $tplCtx = false, $fileExt = 'tpl.php'){
	if ($v) $tplName = array($tplName, $v);
	return site_tpl($name, $tplName, $tplCtx, $fileExt, 'vtpl', true);
}

function site_get($name, $classVar){
	_site::req($name);
	if (property_exists($name, $classVar)) {
		return $name::$$classVar;
	}
	return null;
}
function site_set($name, $classVar, $value){
	$R = _site::name($name);
	if ($R) {
		$R::$$classVar = $value;
		return true;
	}
	return false;
}

/*
	q
		+ site_api('about', 'titul-chart');
		api_site('about/titul-chart');

function site_api($route, $data){
	return _api::get($route, $data);
}
*/

_rt::req('api');

/*
	ug
		api_kmod('side-menu/list', array('by' => 'link'))
	    api_kmod('targets/list')
	    kmod_api::get_prop('list', 'targets/list')
*/
function api_site(/*$method,*/ $requestUri, $data = array()){
	$method = 'get';
	if (func_num_args() === 3) {
		list($method, $requestUri, $data) = func_get_args();
	}
	if (is_array($requestUri)) {
		list($method, $requestUri) = $requestUri;
	}
	return rt_api::request($requestUri, $data, $method, $r = 'site');
}



class site_api extends _api {
	static $r = 'site';

	static $dbg = false;
	static $dbgApi = true;
	static $dbgMe = true;
	static $dbgGet = true;
}
