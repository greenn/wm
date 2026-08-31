<?#0.12.12
_needphp(
	'stacker',
	'g',
	'headers' //чтобы выставить preventHeaders в первых раз
		//иначе позже при первом инклюде, грузится headers, и скидываеи preventHeaders в 0
);


class source extends stacker { //|scrips|src|soruce

	/*
	    man
			сластим req
			принимаем index, впереди аргументов
		eg
			vue:req()
				tplId | { id, name, }
				rName
				tplName
	*/
	static $req_list = array();
	static function req(/*...args*/){
		//$calledClass = get_called_class(); //dbg
		//$parentClass = get_parent_class($calledClass); //dbg

		$args = func_get_args();
		$hash = md5(serialize($args));
		$alreadyCalled = isset(static::$req_list[$hash]);
		//d($args, $hash, $alreadyCalled);

		if ($alreadyCalled) {
			static::$req_list[$hash]++;
			return;
		} else {
			static::$req_list[$hash] = 1;
		}


		$arg1 = func_get_arg(0);
		$method = 'req';
		if (is_integer($arg1)) $method = 'req_index';


		static::dep_req(is_integer($arg1) ? array_slice($args, 1) : $args);

		//d("$calledClass > $parentClass", $method, $args);

		return call_user_func_array("parent::$method", $args);
		//return call_user_func_array("stacker::$method", $args);
	}

	static $dep_list = array();
	//защита от зацикливания и повторных вызовов
	static function dep_control($Args){
		$hash = md5(serialize($Args));
		$isUsed = isset(static::$dep_list[$hash]);
		if (!$isUsed) {
			static::$dep_list[$hash] = $Args;
		}
		//if (end($Args) === 'api/sd.api.js.php')
		///_log('dep_control: '. end($Args), array('$hash' => $hash, '$Args' => $Args, '$dep_list[$hash]' => static::$dep_list[$hash], '$dep_list' => static::$dep_list, '$isUsed' => $isUsed ));
		return $isUsed;
	}

	static function dep_req($Args){
		if (static::dep_control($Args)) return;
		if ($Args[0]) {
			//here: мы будем использовать вставку через tpl
			//проведём некоторую доработку

			//если вставялется название скрипта с доп-параметром, например: env?v3
			//то для вставки через темплейт, этот парамтер надо отмести
			if (strpos($Args[2], '?') !== false) {
				$Args[2] = strstr($Args[2], "?", true);
			}

			array_splice($Args, 3, 0, array(false)); //add ctx for tpl
			array_splice($Args, 2, 0, array('tpl')); //add method 'tpl'
			//dx($Args);
			//dx(get_called_class(), $Args, r__($Args));
			//d(get_called_class(), $Args, r__($Args));

			if (!isset($Args[5])) $Args[5] = false; //сбрасываем ext [wqp]

			//без проверки наличия $REQ_DEP_AUTO_INC | $REQ_DEP_INC
			//выполняем скрипт, и если в нём указаные зависимости, они задействуются
			//(обновят глобальные объекты, своими зависимостями через wjs::req|site_js:req)

			gIncr('preventHeaders');
			$res = r__($Args); //просто выполняем файл как темплейт
			//d($Args, $res);
			gDecr('preventHeaders');
			//_log('dep_req: '. join('|', $Args), array('$res' => $res, '$Args' => $Args));
		}

	}


	//002
	static function rw_req(/*$rule, ...args*/){
		$args = func_get_args();
		array_unshift($args, 'rw');
		call_user_func_array('static::req', $args);
	}

	static function req_name($reqName){
		//rb('page', 'call', 'webkit/main', array('req' => func_get_args()));
		rb('page', 'webkit', func_get_args());
	}

	static function html_export(){
		$list = static::each_with('static::html_export_cb', array());
		$list = array_unique($list);
		//dx($list);
		return $list;
	}

	static function html_ruled_export(){
		$stack = static::get_ruled_stack();
		dx($stack);
	}

	static $html_export_mode = false;
	static function url_export(){
		static::$html_export_mode = 'url';
		$result = static::html_export();
		static::$html_export_mode = false;
		return $result;
	}

	#wo private не работает, не вызываются _cb
	#oo-args - ::each_callback_args
	static function html_export_cb(&$res, $ctx, $hash, $extra){
		$html = '';
		//d($ctx, @$ctx[0], @$ctx[1], @$ctx[2], @$ctx[3], @$ctx[4]);

		$rClass = prop($ctx, 0);
		$rName = prop($ctx, 1);
		$data = prop($ctx, 2);
		$ext = prop($ctx, 3);
		$opt = prop($ctx, 4, true); //ak use_qv
		//d($ctx, $rClass, $rName, $data, $ext, $opt);

		$url = false;
		if ($rClass) {
			//step: добавление $ext к $uri, если имеется query
			if (is_array($data)) {
				if (count($data) === 1) $ext = false; //убираем дефолтное расширение
				else $ext = $data[1]; //добавляем переданные-таким-образом расширение
			}
			$uriData = (array) $data; //$ctx может быть и {a}, хотя обычно строка
			$uri = $uriData[0]; //в $uriData[1] может лежать $ext
			$uri = strtok($uri, '?'); //отделяем query (если оно есть)
			$q = strtok('?'); //получаем query (если оно есть)
			if ($ext) $ext = ".$ext";
			$uri .= $ext.($q ? "?$q" : ''); //добавляем в uriName extension, и уже после query (если оно есть)
			$uriData[0] = $uri; //выставляем uri вместо uriName

			//dx($rClass, $rName, 'uri', $uriData);
			$url = r_($rClass, $rName, 'uri', $uriData);
			//$url = rp($rName, 'uri', $uri);
			//dx($rClass, $rName, 'uri', $uriData, '=', $url);
		} else if (is_string($rName)) {
			//case: путь не через r
			$url = $rName;
			if (static::$cdn) {
				$url = rtrim(static::$cdn, '/').$url;
			}
			//d($url);
		} else { //case: $data = {s} | {ao}
			if ($rName) {
				//case: data лежит в предвыдущем аргументе, eg: js::req(-10, false, array('rb', 'vue', 'vue-init', array('app' => 'App')));
				$ext = $data;
				$data = $rName;
			}

			$html = static::html_ctx($data, $ext); //here: $ext ak $prm
		}

		if ($url) {
			//d($rClass, $rName);
			//uc бывают прямые ссылки без классов
			//eg "/js/lodash/4.17.21/lodash.min.js"
			$passSelfQuery = $rClass && r_($rClass, $rName, 'passRelQuery', $data.$ext);;
			//d($url, $passSelfQuery);
			if ($opt) $url = qv($url, $passSelfQuery);
			$html = static::html_link($url);
		}
		//dx($html, $ctx);

		if (static::$html_export_mode === 'url') {
			$res []= $url;
		} else {
			//base case
			$res []= $html;
		}

	}

	//проверка для внешних url
	static function isExtLink($url){
		static $exclude = array('https://', 'http://', '//');
		$pattern = '~^('.join('|', array_map('preg_quote', $exclude)).')~';
		return preg_match($pattern, $url);
	}

	//05
	static function html_link($url){
		return "<!-- $url -->";
	}

	//05
	static function html_ctx($content, $opts = array()){
		return join(newline, array(
			'<!--',
				jsonPrettyEncode($content),
			'-->',
		));
	}

}


class js extends source {
	//#[extended stacker]
	static $hash = array();
	static $order = array();
	static $_stack = null;
	#/
	static $req_list = array();

	static $cdn;
	static $host;

	static function html_link($url){
		//dx(static::$host, $url);
		if (static::$host) {
			//дополнительная проверка для прямых (напрмер внешних) url
			if (!static::isExtLink($url)) {
				$url = static::$host.$url;
			}
		}
		return _rw::html_link('js', $url);
	}

	static function html_ctx($content, $opts = array()){
		if (isOrdinal($content)) {
			//dx($content);
			$content = r__($content);
		}
		return join(newline, array(
			'<script>',
				$content,
			'</script>',
		));
	}

	static function wreq($name, $index = 0){
		static::req($index, false, "/js/w/$name.js.php");
	}
	static function wreq_js($name, $index = 0){
		static::req($index, false, "/js/w/$name.js");
	}
}
//css::$nameData['hover'] = array(-1, 'web', array('hover/2.3.1/'.(productionMod ? 'hover.css' : 'hover-min.css'), 'css'));
//js::$nameData = array();

class css extends source {
	//#[extended stacker]
	static $hash = array();
	static $order = array();
	static $_stack = null;
	#\
	static $req_list = array();

	static $cdn;
	static $host;

	static function html_link($url){
		if (static::$host) {
			//дополнительная проверка для прямых (напрмер внешних) url
			if (!static::isExtLink($url)) {
				$url = static::$host.$url;
			}
		}
		return _rw::html_link('css', $url);
	}

	static function html_ctx($content, $opts = array()){
		if (isOrdinal($content)) {
			$content = call_user_func_array('r_tpl', $content);
		}
		return join(newline, array(
			'<style type="text/css">',
				$content,
			'</style>',
		));
	}
}

class vue extends source {
	//#[extended stacker]
	static $hash = array();
	static $order = array();
	static $_stack = null;
	#/
	static $req_list = array();

	static function makeName($string){
		$chunks = explode("-", $string);
		foreach ($chunks as $index => $chunk) {
			$chunks[$index] = ucfirst($chunk);
		}
		return join('', $chunks);
	}


	static $extTpl = 'vue.tpl.inc';
	static $extJs = 'vue.js.inc';

	static function alignCtx($vueCtx, &$tplCtx = null){
		if (is_string($vueCtx)) $vueCtx = array('id' => $vueCtx);
		if ($tplCtx !== null) { //[u] opt: можно исключить добавления в контекст vue
			if (!is_array($tplCtx)) $tplCtx = array();
			$tplCtx += $vueCtx; //добавляем $vueCtx к $tplCtx
		}
		return $vueCtx;
	}

	static function dep_req($Args){
		//d($Args);
		//r_($rClass, $rName, 'tpl', $tplName, $tplCtx, $tplExt),
		//$vueJsFile = r_($rClass, $rName, 'path', $tplName, $tplExt);
		//r_($rClass, $rName, 'tpl', $tplName, $tplCtx, $jsExt),
		$Args[4] = static::alignCtx($Args[4], $Args[3]);
		array_splice($Args, 2, 0, array('tpl')); //add method 'tpl'
		array_splice($Args, 5, 2, array(static::$extTpl)); //на 5-ую позицию вставляем ext, остальное удаляем
		//dx($Args, r__($Args));
		r__($Args); //выполняем tpl-скрипт, на предмет триггера зависимостей
		$Args[5] = static::$extJs;
		r__($Args); //выполняем js-скрипт
		//dx($Args, r__($Args));
		//dx($Args);
	}



	static function html_export_cb(&$res, $ctx, $hash, $extra){

		$rClass = prop($ctx, 0);
		$rName = prop($ctx, 1);
		$tplName = prop($ctx, 2);
		$tplCtx = prop($ctx, 3);
		$vueCtx = prop($ctx, 4);
		$tplExt = prop($ctx, 5, static::$extTpl);
		$jsExt = prop($ctx, 6, static::$extJs);
		//d($rClass, $rName, $tplName, $tplCtx, $vueCtx);

		$vueCtx = static::alignCtx($vueCtx, $tplCtx);
		$vueId = prop($vueCtx, 'id', $tplName);
		//01 if (!has_prop($vueCtx, 'name')) $vueCtx['name'] = vue::makeName($vueId);


		$vueHtml = array();

		$vueTplFile = r_($rClass, $rName, 'path', $tplName, $tplExt);
		$vueJsFile = r_($rClass, $rName, 'path', $tplName, $jsExt);

		$hasTpl = is_file($vueTplFile);
		$hasJs = is_file($vueJsFile);

		//if (in_array($vueId, array('ui', 'targets'))) { d($vueJsFile, is_file($vueJsFile), $vueTplFile, is_file($vueTplFile)); }

		if ($hasTpl) {
			$vueHtml = array_merge($vueHtml, array(
				'<script type="text/x-template" id="'.$vueId.'">',
					r_($rClass, $rName, 'tpl', $tplName, $tplCtx, $tplExt),
				'</script>',
			));
		} else {    }

		if ($hasJs) {
			$vueHtml = array_merge($vueHtml, array(
				'<script>',
					r_($rClass, $rName, 'tpl', $tplName, $tplCtx, $jsExt),
				'</script>',
			));
		} else {
			$VueName = prop($vueCtx, 'name', vue::makeName($vueId));
			$vueHtml = array_merge($vueHtml, array(
				'<script>',
					"const $VueName = {",
						"template: '#$vueId'",
					"}",
				'</script>',
			));
		}


		if (0) dx(array(
			'$vueId' => $vueId,
			'@$VueName' => @$VueName,
			'$vueJsFile' => $vueJsFile,
			'is_file($vueJsFile)' => is_file($vueJsFile),

			'$rName' => $rName,
			'$tplName' => $tplName,
			'$tplCtx' => $tplCtx,
			'$tplExt' => $tplExt,

			'$ctx' => $ctx,
			'$vueHtml' => $vueHtml,
			'$hash' => $hash,
			'$extra' => $extra,
		));

		$res []= join(newline, $vueHtml);

	}
}

class _source {

	//формирование аргументов для использования их в html_export_cb
	static function cook_req_args($ctx, $type){ //prepare|collect|pick|get|cook|

		//if ($ctx['rClass'] === 'kot')
		//if ($ctx['args'][0] === 'admin-r') dx(28, $ctx);

		$ctx_og = $ctx; //dbg

		$rClass = $ctx['rClass'];
		$rName = isset($ctx['rName']) ? $ctx['rName'] : null;
		$args = $ctx['args'];/*
			$rule?,
		js,css
				$rName, $uri, $ext, $qv
				$uri, $ext, $qv
				[$uri], $ext, $qv
				[$uri, $ext], $ext, $qv
		vue
		*/
		$ext = $ctx['ext'];


		$rule = false;
		$_ctx = $args;
		if (is_integer($args[0])) {
			//case: has $rule
			$rule = $args[0];
			$_ctx = array_slice($args, 1);
		}
		//dx($rule, $ctx, $rClass, $rName);

		//добавляем имя-ресурса, если вызов был прямо из него
		if ($rName) array_unshift($_ctx, $rName);
		//добавляем тип-ресурса, если вызов был через менеджера
		array_unshift($_ctx, $rClass);

		if (in_array($type, array('js', 'css'))) {
			//dx($rule, $_ctx, count($_ctx));

			$has_opt = array_key_exists('opt', $ctx);
			$opt = prop($ctx, 'opt');

			if (count($_ctx) < 4) {
				//добавляем расширение, т.к. его не передали, доп. образом
				array_push($_ctx, $ext);
			} elseif (prop($_ctx, 3) === true) {
				//case: расширение передано как true (чтобы оставить его по умолчанию),
				// например чтобы дальше указать $opt
				$_ctx[3] = $ext;
			}

			if (count($_ctx) < 5) {
				//добавляем опцию, если имеется
				if ($has_opt) array_push($_ctx, $opt);
				//d($rule, $ctx, $ext, '<', $args);
			}

		} else if ($type === 'vue') {

			//if (!$rName)
			$rName = prop($_ctx, 1);

			$tplName = prop($_ctx, 2);
			if (!$tplName) $tplName = $_ctx[2] = $rName;

			$tplCtx = prop($_ctx, 3);
			if (!$tplCtx) $tplCtx = $_ctx[3] = false;

			$vueCtx = prop($_ctx, 4);
			if (!$vueCtx) $vueCtx = $_ctx[4] = $tplName;
			//dx($_ctx, $vueCtx);

			//if (count($_ctx) < 5) {}
			//if (count($_ctx) < 6) {}
		}




		$args = $_ctx;
		//добавляем $rul если оно есть
		if ($rule !== false) array_unshift($args, $rule);

		//d(11, $ctx_og, $args);
		//if ($ctx['args'][0] === 'admin-r') dx(28, $ctx_og, $args);

		//dx($ctx, $_ctx);
		return $args;
	}

	//готовим, нужно переставить $vueCtx, в конец цепочки аргументов
	static function cook_vueReq_args($args, $hasRName = true){
		$args_og = $args; # $args ~ $vueCtx|$vueId, $rule?, $rName, $tplName, $tplCtx
		$vueCtx = array_shift($args);
		if (is_string($vueCtx)) $vueCtx = array('id' => $vueCtx);
		$vueId = prop($vueCtx, array('id', 'name'));
		if (empty($args)) $args = array($vueId); //частный случай, когда vue_req вызвано только с $vueCtx
		$rule = is_integer($args[0]) ? array_shift($args) : false;
		if ($hasRName) $rName = array_shift($args);

		$args = array_slice($args, 0, 3); //срезаем превышающие значения
		//dx($args, $hasRName, $rName);
		if (!isset($args[0])) { //case: не указан $tplName
			$args[0] = $hasRName ? $rName : $vueId; //сперва проверяем $rName, т.к. $vueId часто кастомный
		}
		if (!isset($args[1])) { //case: не указан $tplCtx
			$args[1] = false;
		}
		if (isset($args[2])) { //case: уже указан $vueCtx
			$args[2] += $vueCtx;
			//$args[2] = $vueCtx + $args[2];
		} else {
			array_push($args, $vueCtx); //в конец добаляем $vueCtx;
		}

		if ($hasRName) array_unshift($args, $rName); //в начало добаляем $rName (если было)
		if ($rule !== false) array_unshift($args, $rule);  //в начало добаляем $rule (если было)
		//dx($args_og, $args);
		return $args;
	}

	/*готовим
		из аргументов req_vue_v
			$rule?, $rName, $vtplName, $vueCtx, $tplCtx
		стандартный контекст
			$rule?, $rName, $tplName, $tplCtx, $vueCtx

		eg
			[oo] iq/test/rt/cook_vueVReq_args.php
			_kot::req_vue_v('side-menu', 'v-1'); == side-menu/v1/side-menu.vue.js.inc
			_kot::req_vue_v(array('side-menu', 'pane'), 'v-1'); ~ side-menu/v1/pane.vue.js.inc
			_kot::req_vue_v('side-menu', array('v-1', 'pane')); ~ side-menu/v1/pane.vue.js.inc
		eq
			_kot::req_vue('side-menu', 'v-2/side-menu', array(), 'side-menu');
			_kot::req_vue_v('side-menu', 'v-2');
	*/
	static function cook_vueVReq_args($args){
		$rule = is_integer($args[0]) ? array_shift($args) : false;
		$rName = $args[0];
		$tplName = $rName;
		if (is_array($rName)) {
			list($rName, $tplName) = $rName;
		}

		$vtplName = prop($args, 1);
		$vueCtx = prop($args, 2, $rName);
		$tplCtx = prop($args, 3, array());

		if (is_string($vueCtx)) $vueCtx = array('id' => $vueCtx);

		if ($vtplName) {
			$tplName = is_array($vtplName) ? join('/', $vtplName) : "$vtplName/$tplName";
		}

		$resArgs = array($rName, $tplName, $tplCtx, $vueCtx);
		if ($rule !== false) array_unshift($resArgs, $rule);  //в начало добаляем $rule (если было)
		return $resArgs;
	}


	static function html_export($order = false){
		if (!is_array($order)) $order = array('css', 'js', 'vue');
		$data = array();
		$data['css'] = css::html_export(); //$cssLinks
		$data['js'] = js::html_export(); //$jsScripts
		$data['vue'] = vue::html_export(); //$vueScripts

		$html = array();
		foreach ($order as $name) {
			$html []= join(newline, $data[$name]);
		}
		return join(newline, $html);
	}

	static function html_ruled_export(){
		//$cssLinks = css::html_export();
		$jsScripts = js::html_ruled_export();
		//$vueScripts = vue::html_export();
	}

	//man iq/man/php/source.class/req_cmpt.man
	static function req_cmpt($rClass, $rName, $cName, $req = 2){
		$cDir = $cName;
		if (is_array($cName)) list($cDir, $cName) = $cName;
		if ($req >= 1) vue::req($rClass, $rName, "$cDir/$cName", false, $cName);
		if ($req >= 2) css::req($rClass, $rName, "$cDir/$cName.css.php");
	}

	static function req_cmpts($stack){
		foreach ($stack as $args_) {
			call_user_func_array('static::req_cmpt', $args_);
		}
	}
}