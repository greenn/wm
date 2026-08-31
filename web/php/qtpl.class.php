<?#3.3.5 - простой темплейтер с контекстом
/*
	возможность выставления временных опций
	возможность составления vue-html
*/

function qtpl($path, $ctx = array()){ //|qtpl_path
	return qtpl::apply_path($path, $ctx);
}

function _qtpl($relPath, $ctx = array()){
	return qtpl::apply($relPath, $ctx);
}

function qtpl_set($relDir, $relExt = ''){
	if (is_array($relDir)) {
		$relDir = array_filter($relDir); //все пустые (empty()) значения массива array будут удалены
		$relDir = join('/', $relDir);
	}
	qtpl::$relDir = $relDir;
	qtpl::$relExt = $relExt;
}

class qtpl {
	static $relDir = '';
	static $relExt = '';
	static function path($relPath, $relDir = true, $relExt = true) { //|take_path|get_path|
		if ($relDir === true) $relDir = static::$relDir;
		if ($relExt === true) $relExt = static::$relExt;
		$path = $relDir ? "$relDir/" : '';
		$path .= $relPath;
		if ($relExt) $path .= ".$relExt";
		return $path;
	}

	static function apply($relPath, $_ctx = array(), $relDir = true, $relExt = true){ //|run|get|html
		$tplPath = static::path($relPath, $relDir, $relExt);

		return static::apply_path($tplPath, $_ctx);
	}

	static function apply_path($tplPath, $_ctx = array()){
		if (!is_file($tplPath)) return '';

		/* возможно плохая идея
			ak: extra-info true
			$__dir = dirname($tplPath);
				если делать, то через другую функцию, которая допишит необходимый контекст
					ak apply_with_autoCtx
		*/

		ob_start();
		include $tplPath;
		$result = ob_get_clean();
		return $result;
	}


	static function ctx($defValues, $ctxValues){
		$ctx = $ctxValues ? array_replace($defValues, $ctxValues) : $defValues;
		return $ctx;
	}


	//|b0:vue_source_html|
	static function vue_source($path){

		$output = array('js' => array(), 'tpl' => array());

		$dir = dirname($path);
		$name = basename($path);

		$jsExt = 'vue.js.inc';
		$tplExt = 'vue.tpl.inc';

		$jsFile = "$dir/$name.$jsExt";
		$tplFile = "$dir/$name.$tplExt";
		//return d($name, array($jsFile => is_file($jsFile), $tplFile => is_file($tplFile)));

		$ctx = array('id' => $name);
		$js = qtpl::apply_path($jsFile, $ctx);
		$tpl = qtpl::apply_path($tplFile, $ctx);

		if ($tpl) {
			$output['tpl'] = array(
				'<script type="text/x-template" id="'.$name.'">',
				$tpl,
				'</script>',
			);

			if (1) if (!$js) {
				$js = "{ template: '#$name' }";
				$js = "_vue('$name', $js)";
			}
			else if (!1)
			if (!$js) {
				$js = "{ template: '#$name' }";
				$js = "VueRoot.addComponent('$name', _vue('$name', $js))";
			}
		}

		if ($js) {
			$output['js'] = array(
				'<script type="text/javascript"  vue="'.$name.'">',
					$js,
				'</script>',
			);
		}

		return $output;
	}

	static function vue_html($path, $glue = newline){
		$src = static::vue_source($path);

		return join($glue, array(
			join(newline, $src['tpl']),
			join(newline, $src['js']),
		));

	}




}