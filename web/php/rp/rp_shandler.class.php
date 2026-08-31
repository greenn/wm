<?#1.15.3

_needphp(
	'rp',
	'x',
	'x/x-slice',
	'fq/_props',
	'fq/_merge',
	'fq/assignValue',
	'fq/undefined',
	'useTemplate',
	'fileUrl',
	'file',
	'json',
	'gt',
	'isAssoc',
	'getCaller',
	'strLess',
	'dirToArray',
	'str',
	'url.class'
);

x('rp_shandler_eg', array(
	'js' => array(
		'dir' => ROOT.'/js',
	),
	'css' => array(
		'dir' => ROOT.'/css',
		'uri-ctx' => true
	),
	'tpl' => array(
		'dir' => ROOT.'/tpl',
	),
	'data' => array(
		'dir' => ROOT.'/data',
	),
	'ctx' => array(
		'dir' => ROOT.'/data/ctx',
	),
));

x('rp_shandler_def', array(
	'baseDir' => ROOT,
	'js' => array(
		'dir' => ROOT.'/js',
	),
	'css' => array(
		'dir' => ROOT.'/css',
		'uri-ctx' => true
	),
	'tpl' => array(
		'dir' => ROOT.'/tpl',
	),
	'data' => array(
		'dir' => ROOT.'/data',
	),
	'ctx' => array(
		'dir' => ROOT.'/data/ctx',
	),
));

/*
	in site_pr {site/php/site_r.php}
*/

//require_once dirname(__FILE__).'/rp_shandler_L.class.php';

class rp_shandler { //static-handler


	//static public function ___callStatic($method, $methodArgs) {}
	// [oo] __ pro my/WCMS/dm/php/rp_shandler/callStatic/v1.php

	static $x = 'rp';
	static $rpName; //не хранит реальное значение, используется только для возможного указания определлёного rpName
	static function rpName(){
		$self = get_called_class(); //$self = static::class;
		$rpName = property_exists($self, 'rpName') ? $self::$rpName : null;
		if (!$rpName) $rpName = preg_replace('~^rp_~', '', $self);

		if ($rpType = static::x('rpType')) { //составное rpName
			$rpName = "$rpType:$rpName"; //¦:¦/¦
		}
		//dx($rpName, static::x('rpType'), $rpType);

		return $rpName;
	}


	static function x($prop = null, $otherwise = null){
		//[ta] локальный static x и dataPath - быстрее ли и насколько от текущего
		$data = x(static::$x);
		/*if (is_array($prop)) {
			$value = static::xSliceArg($prop);
			return $value === null ? $otherwise : $value;
		}*/
		if (!$prop) return $data;
		return prop($data, $prop, $otherwise);
	}

	static function xSlice($prop1 = null, $prop2 = null/*, $propN*/){
		switch (func_num_args()) {
			case 0: return x(static::$x); //0
			case 1: return static::x($prop1); //0
			case 2: return prop(static::x($prop1), $prop2);
			default: //0
				$dataPath = func_get_args();
				return x_slice_path(static::$x, $dataPath);
		}
	}

	//значение
	static function val($name/*, slice-args*/){ //|set|val|value|opt|
		$args = func_get_args();
		array_unshift($args, 'val');
		return call_user_func_array('static::xSlice', $args);
	}
	//значения в виде массива
	/*[eg
		$lims = array(
			static::val('content-image', 'wx'),
			static::val('content-image', 'hx'),
			'data' => static::val('content-image'),
		);
	===
		$lims = static::vals(array(
			array('content-image', 'wx'),
			array('content-image', 'hx'),
			'data' => 'content-image'
		));
	]*/
	static function vals($args/*||..$propNameN*/){
		$res = array();
		if (!func_num_args()) {
			$res = static::x('val');
		} else {
			$sameProp = false;
			if (func_num_args() > 1) {
				$args = func_get_args();
				$sameProp = true;
			}
			 
			foreach ($args as $prop => $name) {
				if ($name === true) $name = $prop;
				if ($sameProp) $prop = $name;
				if (is_array($name)) {
					$res[$prop] = call_user_func_array('static::val', $name);
				} else {
					$res[$prop] = static::val($name);
				}

			}
		}
		return $res;
	}


	//names for css: classes, id
	static function nc($name = true, $subName = false){
		if ($name === true) $name = 'base';
		$n = static::xSlice('nc', $name);
		if (!$n) $n = $name === 'base' ? static::$x : static::nc('base', $name);
		if ($subName) $n .= "-$subName";
		return $n;
	}

	//кдасс q (ak media-query)
	static function cq($q = false, $asSr = false) {
		if ($q === true) $q = '';
		$q = is_stringable($q) ? "-q$q" : '';
		if ($asSr && $q) $q = ".$q";
		return $q;
	}


	/* получение стека имён (классов)
		%1 - cвой nc-класс
		%2 - доп raw-клсса {s|ao}
		%3 - mq-класс, добавление q-класса \hz
	*/
	static function ns($n, $nc, $q = false){
		//d($n, $nc, $q);

		//qk
		//$ns = push_value(static::nc($n), $nc, ($q = static::cq($q)) ? $q : false);

		$ns = array(); //стек классов
		if ($n) $ns []= static::nc($n);
		if (is_array($nc)){ //case: добавление нескольких дополнительных классов
			$ns = array_merge($ns, $nc);
		} elseif (is_stringable($nc)){ //case: добавление класса
			$ns []= $nc;
		}
		if ($q = static::cq($q)) { //case: добавление mq-класса
			$ns []= $q;
		}
		//dx($ns);
		return $ns;
	}

	//вывода классов через пробел (для html-атрибута class="")
	static function anc($n, $nc, $q = false){
		$ns = static::ns($n, $nc, $q);
		return $nc = join(space, $ns);
	}
	//класс для css-селектора
	static function snc($n, $nc, $q = false){
		return $nc = '.'.static::_snc($n, $nc, $q);
	}
	//класс для css-селектора без ведущей (точки)
	static function _snc($n, $nc, $q = false){
		$ns = static::ns($n, $nc, $q);
		return join('.', $ns);
	}

	static function nc_($subName){
		return static::nc('base', $subName);
	}

	//names for js: functions, vars
	//0
	static function nj($name){ /*$subName, $camelCase -- если не он, то '_' */
		return static::xSlice('nj', $name);
	}

	//names for css/js: classes, id, variables
	//0
	static function n($name, $subName = false){ //|[nc/nj]|n|ns|
		$n = static::xSlice('n', $name);
		if ($subName) $n .= "-$subName";
		return $n;
	}



	/*
		tg
			static::path($hash, 'ctx')
			static::path($name, 'css.inc')
			static::path($name, 'css.php')
			static::path($name, 'data.inc')
			static::path($name, 'tpl.php')
			#ar-1: static::path(array('jquery'), js.php');
			static::path(array('jquery', 'js'), js.php');  - js.php проигнорируется
			static::path($name, array('scene', 'php')) - где scene == 'scene' => array('subDir' => 'r/scene') === r/scene/{$name}.php
	        static::data_path(array(%subPath, '')); - получение dir-path = $dataDir/%subPath

			эквивалентны
				$Self::path('preset/13.inc'),
				$Self::path('preset/13', 'inc')
		[vim]
	*/
	static function path($name = false, $ext = false){
		$origExt = $ext; //case #ar-1
		if (is_array($name)) {
			$name = prop($name, 0, '');
			$ext = prop($name, 1, '');
		}


		//step: определяем тип файла
		$spec = is_array($ext) ? $ext : explode('.', $ext);
		$type = $spec[0];
		if (!$type) {
			//case #ar-1: path(array('no-ext-name'), $origExt)
			$type = prop(explode('.', $origExt), 0);
		}

		//step: определяем директорию файла
		$dir = static::xSlice($type, 'dir');
		if (!$dir) {
			$dir = static::x('baseDir');


			if ($subDir = static::xSlice($type, 'subDir')) {
				if ($subDir === true) $subDir = $type;
				$dir .= "/$subDir";
			}
		}

		//step: определяем изменеия для расширения файла
		if ($type === 'ctx') {
			$ext = 'json';
		}

		if ($type === '' || $type === 'img' || $type === 'svg') {
			$ext = '';
		}

		if ($type === 'data' && isset($spec[1])) {
			if ($spec[1] !== 'inc') {
				$ext = $spec[1]; //data.json ~ .json; data.ser ~ .ser;
			}
		}

		if (is_array($ext)) {
			$ext = end($ext);
		}

		$name = strtok($name, '?');
		$q = strtok('?');

		//dx($dir, $name, $ext, $q);
		$path = "$dir/$name".($ext ? ".$ext" : '').($q ? "?$q" : '');
		return $path;
	}


	//eg: $relDir = $Self::relPath(__FILE__);
	static function relPath($callerDir, $subPath = false){
		/*if ($callerDir === true) {
			//не везде работает / пока не работало
			$callerDir = getCallerelPath('dir');
			//d(getCaller('dir'), getCaller('path'), getCaller());
		}*/
		if (is_file($callerDir)) {
			$callerDir = dirname($callerDir);
		}

		$selfPath = static::path();

		$relPath = pathLess($callerDir, $selfPath);
		//dx($callerDir, $selfPath, '=', $relPath);

		if ($subPath) {
			$relPath = rtrim($relPath, '/').'/'.ltrim($subPath, '/');
		}
		//dx($selfPath, $callerDir, $relPath);
		return $relPath;
	}
		//без $subPath - это излишне
		//  realpath($Self::relPath_(__FILE__)) === realpath(dirname(__FILE__))
		static function relPath_($callerDir, $subPath){ //useRelPath
			$_path = static::relPath($callerDir, $subPath);
			return static::path($_path);
		}

	static function relCurPath($subPath = false, $callIndex = 0){
		$callStack = debug_backtrace();
		$callerData = $callStack[$callIndex];
		$caller = $callerData['file'];
		//dx($callStack, $callIndex, $callerData, $caller, getCaller('dir'), getCaller('path'), getCaller());
		return static::relPath($caller, $subPath);
	}
		static function relCurPath_($subPath, $callIndex = 0){
			$_path = static::relCurPath($subPath, $callIndex + 1);
			return static::path($_path);
		}

	//01-zk
	static function path_rel_cur($subPath = false, $ext = false, $callIndex = 0){
		$tempPath = static::path($subPath, $ext);
		//$tempPath = static::path("$subPath.$ext");
		$dirPath = static::path();
		$relPath = strLess($tempPath, $dirPath);
		$relCurPath = static::relCurPath($relPath, $callIndex + 1);
		$fullRelPath = static::path($relCurPath);
		//dx($tempPath, $dirPath, $relPath, $relCurPath, $fullRelPath, static::relCurPath_($relPath, $callIndex + 1));
		return $fullRelPath;
		//or dirty path_rel_cur
		//здесь не чёткая работа с ext( не учитываются dir для ext)
		return relCurPath_("$subPath.$ext",  $callIndex + 1);
	}

	//$Self::uri( $Self::relCurPath('/hover/BUTTONS.gif') )


	private static function inc_getPath($subPath){
		$resPath = false;
		$path = static::path($subPath);
		if (is_file($path)) {
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$asPhp = $ext === 'php' || $ext === 'inc';
			if ($asPhp) {
				$resPath = $path;
			}
		}
		return $resPath;
	}

	static function inc($subPath, $_incCtx_ = null){
		if ($path = static::inc_getPath($subPath)) {
			if (is_array($_incCtx_)) extract($_incCtx_);
			include $path;
		}
    }

    static function inc_once($subPath, $_incCtx_ = null){
	    if ($path = static::inc_getPath($subPath)) {
		    if (is_array($_incCtx_)) extract($_incCtx_);
		    include_once $path;
	    }
    }

	//p0/td ak inc:()
	//static function req(){}


	static $file_cache = array();
	static function file_save($path, $content = ''){
		if ($saved = save_file($path, $content)) {
			static::$file_cache[$path] = $content;
		} else {
			d('ошибка сохраненния', $path, $content); //[wr]
		}
		return $saved;
	}
	static function file_get($path, $retry = false){
		if ($retry || !isset(static::$file_cache[$path])) {
			$res = file_get_contents($path);
			$cached[$path] = $res;
		} else {
			$res = static::$file_cache[$path];
		}
		return $res;
	}



	static function uri($name = null, $type = false, $ctx = false, $query = false){
		$path = static::path($name, $type);
		$uri = fileUrl($path);
		if (!empty($ctx)) {
			$uri .= '?'.static::ctx_save($ctx);
		}
		if ($query) $uri = url::q_ext($uri, $query);
		return $uri;
	}
	static function ctx_save($ctx){
		$json = jsonEncode($ctx);
		$hash = hash('adler32', $json);
		$path = static::path($hash, 'ctx');
		if (!is_file($path)) {
			static::file_save($path, $json);
		}
		return $hash;
	}
	static function ctx_get($hash){
		$res = null;
		$path = static::path($hash, 'ctx');
		if (is_file($path)) {
			$json = static::file_get($path);
			$res = json_decode($json, true);
		}
		return $res;
	}
	static function uriCtx($defValues = false, $ctxValues = true, $orderValues = true){
		if (!x('__useTemplate')) { //notUsingTemplate - case: не используется useTemplate
		    if (pageQuery !== '') { //hasUriArgs
				$hash = hit(gt('hash'), gi(0, 'key'), false); //lookForHash
				if ($hash) {
					$ctxValues = $hash;
				}
			}
		}
		return static::tplCtx($defValues, $ctxValues, $orderValues);
	}



	static function css_uri($name, $ctx = false, $query = false){
		if (!static::xSlice('css', 'uri-ctx')) $ctx = false;
		$uri = static::uri($name, 'css.php', $ctx, $query);
		return $uri;
	}
	static function css_uri_host($name, $ctx = false, $query = false){
		$uri = static::css_uri($name, $ctx, $query);
		if (preg_match('~^[\/][^\/]~', $uri)) $uri = hostUrl.$uri; //https://regex101.com/r/M4ZpcQ/1/
		return $uri;
	}
	static $css_link = "<link type=\"text/css\" rel=\"stylesheet\" href=\"%s\" />\r\n";
	static function css_link($name, $ctx = false, $query = false){
		$uri = static::css_uri($name, $ctx, $query);
		return sprintf(static::$css_link, $uri);
	}
	static function css_link_host($name, $ctx = false, $query = false){
		$uri = static::css_uri_host($name, $ctx, $query);
		return sprintf(static::$css_link, $uri);
	}

	static function css_inc($name, $ctx = false){
		$path = static::path($name, 'css.inc');
		if (is_string($ctx)) $ctx = static::ctx_get($ctx); //case: ctx is hash
		$res = useTemplate($path, $ctx);
		return $res;
	}

	/*
		[dd]
		    ::css_inline('main.toggled', null, false, 'css.inc');
            ::css_inline(array('main.toggled', 'css.inc'));
	*/
	static $css_inline = "<style type=\"text/css\">\r\n%s\r\n</style>\r\n";
	static function css_inline($name, $ctx = false, $wrapper = true){
		$path = static::path($name, 'css.php');
		if (is_string($ctx)) $ctx = static::ctx_get($ctx); //case: ctx is hash
		$res = useTemplate($path, $ctx);
		if ($wrapper) {
			$res = sprintf(static::$css_inline, $res);
		}
		return $res;
	}

	//простое превращание массива css-данных в строку стилей
	static function str_css($css_data, $css_add = null){ //css_styles|str_css|
		if (is_array($css_data)) {
			$styles = array();
			if (isOrdinal($css_data)) {
				$styles = array_merge($styles, $css_data);
			} else {
				foreach ($css_data as $val => $prop) {
					$styles []= "$val: $prop";
				}
			}
			$styles = join('; ', $styles);
		} else {
			$styles = $css_data ? (string) $css_data : '';
		}


		if ($css_add) {
			if ($css_add = static::str_css($css_add)) {
				$styles .= ';'.static::str_css($css_add);
			}
		}
		return $styles;
	}


	static $css_import = "@import \"%s\";\r\n";
	static function css_import($name, $ctx = false, $query = false){
		$uri = static::css_uri($name, $ctx, $query);
		return sprintf(static::$css_import, $uri);
	}

	static function js_uri($name, $ctx = false, $query = false){
		if (!static::xSlice('js', 'uri-ctx')) $ctx = false;
		$uri = static::uri($name, 'js.php', $ctx, $query);
		return $uri;
	}
	static function js_uri_host($name, $ctx = false, $query = false){
		$uri = static::js_uri($name, $ctx, $query);
		//if (preg_match('~^[\/][^\/]~', $uri)) $uri = '//'.HOST.$uri;
		if (preg_match('~^[\/][^\/]~', $uri)) $uri = hostUrl.$uri;  //https://regex101.com/r/M4ZpcQ/1/
		return $uri;
	}
	static $js_link = "<script type=\"text/javascript\" src=\"%s\"></script>\r\n";
	static function js_link($name, $ctx = false, $query = false){
		$uri = static::js_uri($name, $ctx, $query);
		return sprintf(static::$js_link, $uri);
	}
	static function js_link_host($name, $ctx = false, $query = false){
		$uri = static::js_uri_host($name, $ctx, $query);
		return sprintf(static::$js_link, $uri);
	}
	static $js_inline = "<script type=\"text/javascript\">\r\n%s\r\n</script>\r\n";
	static function js_inline($name, $ctx = false, $wrapper = true){
		$path = static::path($name, 'js.php');
		if (is_string($ctx)) $ctx = static::ctx_get($ctx); //case: ctx is hash
		$res = useTemplate($path, $ctx);
		if ($wrapper) {
			$res = sprintf(static::$js_inline, $res);
		}
		return $res;
	}


	//ak data_inc
	static function data($name, $extend = false){
		static $cache = array(); //для $path пойдёт, но эти данные в каждом rp
		$path = static::path($name, 'data.inc');
		//dx($path, is_file($path));
		if (!isset($cache[$path])) {
			$cache[$path] = inc($path, INC_RES_AS_ARRAY);
		}
		$data = $cache[$path];
		if (is_array($extend)) $data = array_replace($data, $extend);
		return $data;
	}
	static function dataProp($name, $prop, $otherwise = null){
		$data = static::data($name);
		return prop($data, $prop, $otherwise);
	}
	static function dataSlice($name, $prop1 = null, $prop2 = null/*, $propN*/){ //0
		//$data = is_array($name) ? $name : static::data($name);
		$data = static::data($name);
		switch (func_num_args()) {
			case 1: return $data; //0
			case 2: return prop($data, $prop1);
			case 3: return prop(prop($data, $prop1), $prop2);
			default: //0
				_needphp('dataPath');
				$dataPath = func_get_args();
				return dataPath($dataPath, $data);
		}
	}


	static function data_path($namePath, $type = true){
		$type = $type === true ? 'json' : (!$type ? 'string' : $type);
		return static::path($namePath, "data.$type");
	}

	static function data_hasPath($namePath, $type = true){
		$dataPath = static::data_path($namePath, $type);
		return is_file($dataPath);
	}

	static function data_save($namePath, $data = '', $type = true){
		$path = static::data_path($namePath, $type);
		switch ($type) {
			//data_save_json
			case 'json': $content = jsonEncode($data); break;
			//data_save_ser
			case 'ser': $content = serialize($data); break;
			default: $content = $data;
		}
		static::file_save($path, $content);
		return $path;

		return static::file_save($path, $content);
	}

	static function data_get($namePath, $type = true){
		static $cache = array();
		$data = null;
		$path = static::data_path($namePath, $type);
		if (is_file($path)) {
			$content = static::file_get($path);
			switch ($type) {
				//data_get_json
				case 'json': $data = json_decode($content, true); break;
				//data_get_ser
				case 'ser': $data = unserialize($content); break;
				default: $data = $content;
			}
		}
		return $data;
	}

/* pd_ */
	//[!!create] static $pd_%data = '%data dataPath'; //%data dataPath
	/*[!!create] static function pd_%data_def() { return array(); } //данные по умолчанию для pd-данных */
	static function pd_data($pdName, $rebuild = false){
		static $stack = array();
		$vpd = "pd_$pdName"; //DataPath variable

		$data = isset($stack[$pdName]) ? $stack[$pdName] : false;

		if (!$data || $rebuild) {
			$stack[$pdName] = static::data_get(static::$$vpd);
		}

		return $stack[$pdName];
	}
	static function pd_data_save($pdName, $data, $rebuild = false){
		$vpd = "pd_$pdName"; //DataPath variable
		static::data_save(static::$$vpd, $data);
		if ($rebuild) static::pd_data($pdName, true);
	}

	static function pd_data_def($vpd){ //can be extended
		return array();
	}
	static function pd_data_get($pdName, $rebuild = false){
		$data = static::pd_data($pdName, $rebuild);

		if (!$data) {
			$mpd = "static::pd_{$pdName}_def"; //defDataMethod - метода получения данных по умолчанию
			$defData = is_callable($mpd) ? call_user_func($mpd) : static::pd_data_def($pdName);
			static::pd_data_save($pdName, $defData);
			$data = static::pd_data($pdName, true);
		}

		return $data;
	}
	static function pd_data_prop($pdName, $propName, $otherwise = null) {
		$data = static::pd_data($pdName);

		if (is_array($propName)) {
			$slicePath = $propName;
			return dataPath($slicePath, $data, $otherwise);
		} else {
			return prop($data, $propName, $otherwise);
		}
	}


/* pdi_ */
    //[!!create] static $pdi_%data = '%dataItem pathPattern'; //%dataItem pathPattern
    /*[!!create] static function $pdi_%dataItem_def() { return array(); } //данные по умолчанию для pd-данных */
    /*-\pdi_data_path [!!create] static function $pdi_%dataItem_path() { ... } //путь до файла-данных */

    //получение данных для pdi_Элемента
    static function pdi_data($pdiName, $pdiFileName){
        $pdiPath = static::pdi_data_path($pdiName, $pdiFileName); //dataPath
        $data = static::data_get($pdiPath);
        return $data;
    }

    //метод (по умолчанию) получения пути для PathDataItem
    static function pdi_data_path($pdiName, $pdiFileName){
        $pdn = static::${"pdi_$pdiName"}; //DataItemPatternPath

        /*if (is_callable($pdiPathMethod = "static::pdi_{$pdiName}_path")) {
            $pdiPath = call_user_func($pdiPathMethod, $pdiName, $pdiFileName, $pdn);
        } else {}*/

        $pdiPath = strtr($pdn, array(
            '%filename' => $pdiFileName
        ));
        return $pdiPath;
    }

    static function pdi_data_save($pdiName, $pdiFileName, $data){
        $pdiPath = static::pdi_data_path($pdiName, $pdiFileName); //dataPath
        static::data_save($pdiPath, $data);
    }

    //0
    static function pdi_data_def($vpd){ //can be extended
        return array();
    }

    static function pdi_data_get($pdiName, $pdiFileName){
        $data = static::pdi_data($pdiName, $pdiFileName);
        return $data;
    }
    //01
    static function pdi_data_prop($pdiName, $pdiFileName, $propName, $otherwise = null) {
        $data = static::pdi_data($pdiName, $pdiFileName);

        if (is_array($propName)) {
            $slicePath = $propName;
            return dataPath($slicePath, $data, $otherwise);
        } else {
            return prop($data, $propName, $otherwise);
        }
    }
    
    //id
    static function pdi_dataList($pdiName){
        $dataList = array();
        $pdl = false; //DataListPath
        if (isset(static::${"pdl_$pdiName"})) {
            $pdl = static::${"pdl_$pdiName"};
        } else {
            $pdn = static::${"pdi_$pdiName"}; //DataItemPatternPath
            $pdl = strtr($pdn, array(
                '%filename' => ''
            ));
        }

        $dirPath = static::data_path(array($pdl, ''));

        if (is_dir($dirPath)) {
            $fileList = dirToArray($dirPath, 1, false);
            foreach ($fileList as $fileName => $filePath) {
                $invoiceId = basename($fileName, '.'.pathinfo($fileName, PATHINFO_EXTENSION));
                $dataList[$invoiceId] =  static::pdi_data_get($pdiName, $invoiceId);
            }
        }

        return $dataList;

    }

    

/* * */

    static $DBG_TplName = true;
    //static $DBG_TplNameSkip = array(); //dr1
    static $DBG_TplNameBellow = array(); //flag
    static $DBG_TplCC = array( //comments config
	    'html' => array('<!--', '-->'),
	    'css' => array('/*', '*/'),
    );
    //для того чтобы не использовать комментарии например перед DOCTYPE
    static function DBG_TplNameBellow($tpl_code) {
    	//d($tpl_code, in_array($tpl_code, static::$DBG_TplNameBellow), static::$DBG_TplNameBellow);
    	return in_array($tpl_code, static::$DBG_TplNameBellow);
    }

	static function hasTpl($name = true, $ext = 'tpl.php'){
		$path = static::path($name, $ext);
		return is_file($path);
	}

	static function tpl($name = true, $ctx = false, $ext = 'tpl.php'){
		if ($name === true) $name = static::rpName(); //dx($name);

		if (is_array($name)) {
			$nameConf = $name;
			list($name, $ext) = $nameConf;
		}
		$path = static::path($name, $ext);

		//$dbgName = 'dbg-pane';
		//if ($name === $dbgName) dx($path, $ctx);
		//if ($name === $dbgName) x('fk-dbg', 1);
		$result = useTemplate($path, $ctx);

		if (self::$DBG_TplName && is_string($result)) {
			$fileExt = 'html';
			if (mb_endsWithAny($path, array('css.tpl.php', 'tpl.css.php'))) { //$DBG_TplCssExt = array('css.tpl.php', 'tpl.css.php');
				$fileExt = 'css';
			}
			list($cc_start, $cc_end) = static::$DBG_TplCC[$fileExt];

			$tpl_id = static::rpName().':'.$name;

			if (self::DBG_TplNameBellow($name)) {
				$result = $result
					.newline."$cc_start [/$tpl_id] $cc_end".newline
				;
			} else {
				$result = newline."$cc_start [$tpl_id] $cc_end".newline
					.$result
				;
			}
		}


		return $result;
	}

	static function tpl_($tplArgs){
		return call_user_func_array('static::tpl', $tplArgs);
	}

	static function cssTpl($name, $ctx = false, $ext = 'tpl.css.php'){ //|cssTpl|tpl_css|css_tpl|
		return static::tpl($name, $ctx, $ext);
	}

	//helper для разводки пришедших аргуметов
	//[oo _\pro my\WCMS\dm\php\rp_shandler\tplCtx]
	/* eg
		-   -
			$_ctx = $Self::tplCtx(array(
				'lang' => false,
				'nc' => '',
			)); //d($_ctx);

			$lang = $_ctx['lang'];
			$nc = $_ctx['nc'];
		-   -
			$_ctx = mb::tplCtx(
		        mb::data('def-set'), //web/tools/mb/data/def-set.data.inc
			    true, //переменные текущего контекста
		        ck('mb') //локальная кука с настройками
		    );
			$uri = $_ctx['uri'];
	*/
	#0.4
	static function tplCtx($defValues = false, $ctxValues = true, $extValues = false){
		if ($ctxValues === true) {
			$ctxValues = x_end('__templateCtx');
		}
		//dx($defValues, $ctxValues, $extValues);

		if (is_string($ctxValues)) { //00
			$ctxHash = $ctxValues;
			$ctxValues = static::ctx_get($ctxHash);
		}
		if (!is_array($ctxValues)) $ctxValues = array();

		//d($ctxValues);
		_array_unset_undefined($ctxValues); //убираем свойства помеченные как undefined(), чтобы вместо них сработали $defValues
		//d($ctxValues);

		if (is_array($extValues)) {
			$ctxValues = array_replace_recursive($ctxValues, $extValues);
		}

		if (!is_array($defValues)) $defValues = array();

		//$ctx = array_merge($defValues, $ctxValues); //<#0.4
		$ctx = array_replace($defValues, $ctxValues);
		//dx($ctx, $defValues, $ctxValues, $extValues);

		$ctx['__defCtx'] = $defValues;
		$ctx['__tplCtx'] = $ctxValues;
		$ctx['__extCtx'] = $extValues;

		return $ctx;
	}

	//расширение контекста дополнительными данными
	//с выбором свойства для среза дополнительного котнекста
	static function tplx($name = true, $ctx = false, $transitCtx = null, $transitName = true){

		if (!$transitName) { //case: tplx(%,%,$ctx,false) - расширение просто дополнительным контекстом
			$extraCtx = $transitCtx; //для понимания
			$ext = $extraCtx;
		} else { //case: транзитный контекст
			if ($transitName === true) $transitName = $name;
			$ext = prop($transitCtx, $transitName);
		}

		if ($ext) {
			if (!is_array($ctx)) $ctx = array();
			$ctx = array_replace($ctx, $ext);
		}

		return static::tpl($name, $ctx);
	}

	//сладкий вариат для среза свойства [def(transit)] от доп.контекста для получения транизтного контекста
	static function tplxx($name = true, $ctx = false, $parentCtx = null, $transitProp = true, $transitName = true){
		if ($transitProp === true) $transitProp = 'transit';
		$transitCtx = prop($parentCtx, $transitProp);
		return static::tplx($name, $ctx, $transitCtx, $transitName);
	}

	//0 \mb-section
	static function tplEnv($name = true, $ctx = false){ //|tplInline|tplEnv|
		$envCtx = array(
			//default values:
			'css' => null,
			'js' => null,
			'is_css_inline' => true,
			'is_js_inline' => true,
		);
		if (is_array($ctx)) {
			$envCtx = array_replace($envCtx, $ctx);
		}
		return static::tpl($name, $envCtx);
	}


	static $log = array();
	static function log($name, $data){
		if (func_num_args() > 2) $data = array_slice(func_get_args(), 1);
		if (!isset(static::$log[$name])) static::$log[$name] = array();
		static::$log[$name] []= $data;
		return $data;
	}
	static function log_(){
		$log = call_user_func_array('static::log', func_get_args());
		d($log);
	}
	static function log_x(){
		$log = call_user_func_array('static::log', func_get_args());
		dx($log);
	}


	//$cond - указание выбора из стека $log[$name]
	//  true - последний
	static function get_log($name, $cond = null){
		if (!isset(static::$log[$name])) return null;
		$log = static::$log[$name];
		//dx($log, end($log));
		if (is_null($cond)) return $log;
		if (is_true($cond)) {
			$last = end($log);
			reset($log);
			return $last;
		}
		//td find_log($cond)
	}

	static function url_response($url, $set = false) { //api_response|json_response|
		static $cached = array();
		$set = set($set === true ? array('cache' => true) : $set);

		if ($set->cache && isset($cached[$url])) {
			return $cached[$url];
		}


		if ($set->curl){
			_needphp('htmlByUrl', 'json');
			if (!is_array($options = $set->curl_opt)) $options = array();
			if ($set->post) {
				$options['post'] = $set->post;
			}
			$re = htmlByUrl($url, $options, true);
			$response = $re['response']['html'];
			$data = jsonTryDecode($response);
			d($re, $response, $data);
		} else {
			$json = file_get_contents($url);
			$data = json_decode($json, true);
		}

		if ($set->cache) {
			$cached[$url] = $data;
		}

		return $data;
	}



	/*  names-of-order-classes
	    ts:
			web/test/web/php/rp/ns_o.php
			web/test/help/mod.php?1&2&3&4&5
		eg:
			$Self::ns_o($index, 3);
			$Self::ns_o($index, 3, '-o3n');
			$Self::ns_o(array($index, null, $lastKey), '-od', '-o2', '-o3');
			$Self::ns_o(array($key, $firstKey, $lastKey, $index), 4)
			$Self::ns_o(array($key, null, null, $index), '-o4n')

			$o_ns = $Self::ns_o(array($index, $firstIndex, $lastIndex), 2);
		    $o_ns2 = $Self::ns_o(array($index, $firstIndex, $lastIndex), array('-od', '-o2'));
		    $o_ns3 = $Self::ns_o($index, array('-od', '-o2'));
		    $o_ns4 = $Self::ns_o($index, 2);
	*/
	static function ns_o($indexData, $names = array('-od', '-o2')/*, $addName*/){
		$args = func_get_args(); //dx($args);

		$res = array();

		$names = array();

		$namesData = array_slice($args, 1);
		foreach ($namesData as $nameData) {
			if (is_string($nameData)) {
				$names []= $nameData;
			} else if (is_integer($nameData)) { //|oE|o2| / |oE3|o3| /
				for ($i = 2; $i <= $nameData; $i++) $names []= "-o$i";
			} else if (is_array($nameData)) {
				$names = array_merge($names, $nameData);
			}

		}

		$index = $indexData;
		$key = $index;
		$firstKey = null;
		$lastKey = null;
		if (is_array($indexData)) {
			if (isset($indexData[0])) {
				$index = $indexData[0];
				$key = $index;
			}
			if (isset($indexData[1])) { //case: null проигнорируется
				$firstKey = $indexData[1];
				$names []= '-of'; // first |oF|of|
			}
			if (isset($indexData[2])) {
				$lastKey = $indexData[2];
				$names []= '-ol';
			}
			if (isset($indexData[3])) { //case: при {aa}, 4-ым аргументом передаём $index инкременируемый снаружи вручную
				$index = $indexData[3];
			}
		}
		//case: is_set($indexData)

		$names = array_unique($names);

		//d($names, array($index, $firstKey, $lastKey));
		foreach ($names as $nc) {
			switch ($nc) {
				case '-of': //case: первый элемент |oF|of|
					if ($key === $firstKey) $res []= $nc; break;
				case '-ol': //case: последний элемент |oL|ol|
					if ($key === $lastKey) $res []= $nc; break;
				case '-od': //case: нечётный (odd) элемент |oO|od|
					if ($index % 2 === 0) $res []= $nc; break;
				default: { //
					if (preg_match('~^-o([\d]+)$~', $nc, $match)) {
						# case: n-ый элемент
						//d('N', $index, $nc, $match[1], ($index + 1) % $match[1] === 0);
						if (($index + 1) % $match[1] === 0) $res []= $nc;
					} elseif (preg_match('~^-o([\d]+)n([\d]*)$~', $nc, $match)) {
						# case: следующий %x после n-ого элемент
						//$xN = floatval($match[2] ? $match[2] : 1); //рабочий, но если $xN > $y работать не будет
						$y = $match[1];
						$xN = fmod($match[2] ? $match[2] : 1, $y);
						//d("o{$y}n{$xN}", $index + 1, $y, fmod($index + 1, $y), $xN);
						if (fmod($index + 1, $y) === $xN) $res []= $nc; //"-o{$y}n{$xP}"
					} elseif (preg_match('~^-o([\d]+)p([\d]*)$~', $nc, $match)) {
						# case: предыдущий %x перед n-ым элемент
						$y = $match[1];
						$xP = fmod($match[2] ? $match[2] : 1, $y);
						//d(($index + 1)."($index) {$y}n{$xP}", $y, $xP, $y - $xP, '=', fmod($index + 1, $y));
						if (fmod($index + 1, $y) === fmod($y - $xP, $y)) $res []= $nc; //"-o{$y}p{$xP}"
							/*
							    q-aaa
									но это = fmod для превращение в случаи o4p4 ~ 4 в 0
							*/
					} elseif (preg_match('~^-o([\d]+)l(.+)$~', $nc, $match)) {
						# case: предыдущие элементы перед переходом ak line
						/*
						    -o4l2 - второй проход по 4 элемента (idx: 4,5,6,7 / n: 5,6,7,8)
							-o2lf - первый проход по 2 элемента
							-o2ll - последдний проход по 2 элемента (нужен $lastIndex)
							-o3le - (even) чётные проходы
							-o3lo - (odd) нечётные проходы
						*/
						$n = $match[1]; //модуль - кол-во элементов в проходе
						$l = $match[2]; //номер строки (прохода)
						$isEven = ($l === 'e');
						$isOdd = ($l === 'o');
						if ($l === 'f') $l = 1;
						if ($l === 'l' && !is_null($lastKey)) $l = ceil($lastKey / $n);
						$l = (float) $l - 1;
						$L = floor($index / $n);
						//d('L', $index, $n, $l, $index/$n, floor($index/$n));
						$ok = $L === $l;
						if ($isEven || $isOdd) {
							$ok = $isEven ? ($L % 2 == 0) : ($L % 2 != 0);
						}
						if ($ok) $res []= $nc;

					} else {
						d('unknown-name', $nc, $indexData);
					}
				}
			}
		}

		return $res;

	}

	// [n] -od === -o2p1
	static function nc_o($indexData, $names = array('-od', '-o2')/*, $addName*/){
		$args = func_get_args();
		$ns = call_user_func_array('static::ns_o', $args);
		return join(space, $ns);
	}

	static function call($name = true, $ctx = false, $ext = 'inc'){
		/*//ak buildPath|pathBuild($name, $ext)|pathWizard
		if ($name === true) $name = static::rpName(); //dx($name);

		if (is_array($name)) {
			$nameConf = $name;
			list($name, $ext) = $nameConf;
		}*/
		$path = static::path($name, $ext);
		//dx($path, is_file($path));

		x_push('__templateCtx', $ctx);
		$result = inc($path, INC_RES_AS_DATA);
		x_pop('__templateCtx');

		return $result;
	}

	//было как tplCtx, но в итоге он (tplCtx) и используется
	//static function callCtx($defValues = false, $ctxValues = true, $extValues = false){}

}