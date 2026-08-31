<?#0.3.3
//root resources
_needphp(
	'rw'
);
//_needphp();


class rt extends rw {
	static $rClass = 'rt';
	static $temp; //01

	static $vtpl = false;
	static $vdef = 0;
	static $vname = array();

	//Добавлять во внутрение url get-параметры вызывающей страницы
	static $qp = true;

	static function passRelQuery($relPath){
		$passThisPath = is_array(static::$qp) && in_array($relPath, static::$qp);
		$passAllPathes = static::$qp === true;
		//d($relPath, static::$qp, $passThisPath, $passAllPathes);
		return $passThisPath || $passAllPathes;
	}


#= extend-update
	static function nc($name = true, $subName = false, $usePrefix = true){
		$n = parent::nc($name, $subName);
		return $usePrefix ? 'r'.$n : $n;
	}
#\

#= lang
	static $lang = array();
	static function lang($code = true, $lang = true){
		static $db = array();
		static $dic = array();
		if (!$db) { //|| $rebuild
			_lang::$dbg = static::cfg('rName');
			//dx(static::$lang);
			$db = _lang::build_lang_cfg(static::$lang);
			//dx($db);
			//if (static::cfg('rName') === 'lang-menu') dx($db);
			//d(static::cfg('rName'), $db);
		}

		if ($lang === true) $lang = cur_lang();

		if ($code === true) {
			//if (!isset($dic[$lang])) $dic[$lang] = _lang::get_dic($db, $lang); $trans = $dic[$lang];
			//case: получить весь словарь    для указанного языка
			$trans = _lang::get_dic($db, $lang);
		} else {
			//case: получить перевод слова по запросу
			$trans = _lang::get_translate($db, $code, $lang);
		}

		//dx($code, @$db[$code], $lang, $trans);
		return $trans;
	}

#\


#= source
	static function req_source($type, $args, $ext = ''){

		//if ($type === 'vue' && $args[0] === 'admin-r') x('dbg', true);

		$args = _source::cook_req_args(array(
			'rClass' => static::$rClass,
			'rName' => static::cfg('rName'),
			'args' => $args,
			'ext' => $ext,
		), $type);

		//d(10, static::$rClass, $args, $type);

		call_user_func_array("$type::req", $args);
	}

	static function req_js(/*$rule, $uri, $ext, $qv = true*/){
		//return static::req_source('js', func_get_args(), 'js');
		return static::req_source('js', func_get_args(), 'js.php');
	}

	static function req_css(/*$rule, $uri, $ext, $qv = true*/){
		//return static::req_source('css', func_get_args(), 'css');
		return static::req_source('css', func_get_args(), 'css.php');
	}

	static function req_vue(/*$rule?, $tplName, $tplCtx, $vueCtx*/){
		return static::req_source('vue', func_get_args());
	}

	static function vue_req(/*$vueCtx, $rule?, $tplName, $tplCtx*/){
		$args = _source::cook_vueReq_args(func_get_args(), false);
		return static::req_source('vue', $args);
	}

	static function req_vue_name($vueName){
		$def = array($vueName, $vueName, array(), $vueName);
		$cfg = static::cfg('vue-name');
		dx($cfg);
	}
#\


#= api

	static function api($uri, $data = array(), $method = 'POST'){
		$rName = static::cfg('rName');
		if (is_array($uri)) list($method, $uri) = $uri;
		return rt('api', 'request', "$rName/$uri", $data, $method, static::$rClass);
	}
	static function api_get($uri, $data = array()){
		return static::api($uri, $data, 'GET');
	}

	//внутренний api
	static function _api($uri, $data = array(), $method = 'GET'){
		$data['access_token'] = true;
		return static::api($uri, $data, $method);
	}
	static function _api_post($uri, $data = array()){
		return static::_api($uri, $data, 'POST');
	}

	static function api_data($uri, $data = array(), $method = 'GET'){
		$response = static::api($uri, $data, $method);
		return prop($response, 'data');
	}
	static function api_data_prop($prop, $uri, $data = array(), $method = 'GET'){
		$response = static::api($uri, $data, $method);
		//dx($response);
		return propChain($response, array('data', $prop));
	}

	static function _api_data($uri, $data = array(), $method = 'GET'){
		$response = static::_api($uri, $data, $method);
		return prop($response, 'data');
	}
	static function _api_data_prop($prop, $uri, $data = array(), $method = 'GET'){
		$response = static::_api($uri, $data, $method);
		return propChain($response, array('data', $prop));
	}
#\

#= db
	static function db($method, $ctx = array()){
		$result = static::call("_db/$method", $ctx);
		return $result;
	}
#\

}

//менеджер по работе с rp классом
class _rt extends _rw {
	static $rClass = 'rt';
	static $db = array(); //своя база
	static $cache = array(); //свой cache

	static function rDir(){
		return ROOT;
	}

	static function className($name){
		return "rt_$name";
	}

	#= req_source


	static function req_source($type, $args, $ext = ''){
		/*code-навигация*/ if (0) { vue::req(); vue::html_export_cb(); }

		$args = _source::cook_req_args(array(
			'rClass' => static::$rClass,
			'args' => $args,
			'ext' => $ext,
		), $type);

		//d($args);
		///dx($args);
		///if (is_callable("$type::req"))
		call_user_func_array("$type::req", $args);
	}

	static function req_js(/*$rule, $rName, $uri, $ext, $qv = true*/){
		return static::req_source('js', func_get_args(), 'js.php');
	}

	static function req_css(/*$rule, $rName, $uri, $ext, $qv = true*/){
		return static::req_source('css', func_get_args(), 'css.php');
	}

	static function req_vue(/*$rule?, $rName, $tplName, $tplCtx, $vueCtx*/){
		return static::req_source('vue', func_get_args());
	}

	static function req_vue_v(/*$rule?, $rName, $vtplName, $vueCtx, $tplCtx*/){
		return static::req_source('vue', _source::cook_vueVReq_args(func_get_args()));
	}


	static function vue_req(/*$vueCtx, $rule?, $rName, $tplName, $tplCtx*/){
		return static::req_source('vue', _source::cook_vueReq_args(func_get_args()));
	}

}

function rt($name, $method = null/*, $arg1, $arg2*/){
	return _r_('rt', func_get_args());
}
/*
function rt_($name, $method = null/*, $arg1, $arg2* /){
	if ($R = _rt::name($name)) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($R, $method), $args);
	}
}
*/

function rt_tpl($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
	return _r_tpl('rt', func_get_args());
}
/*
function rt_tpl_($name, $tplName, $tplCtx = false, $fileExt = 'tpl.php'){
	return rt($name, 'tpl', $tplName, $tplCtx, $fileExt);
}
*/



class rt_root extends rt {

}

_rt::reg('root', array(
	'className' => 'rt_root',
	'rDir' => ROOT,
));

