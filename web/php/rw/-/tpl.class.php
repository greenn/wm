<?#0.1

class rw_data {

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


}