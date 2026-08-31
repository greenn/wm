<?#0.1

class rw__ {

//x

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

	static function uri($name = null, $type = false, $ctx = false, $query = false){
		$path = static::path($name, $type);
		$uri = fileUrl($path);
		if (!empty($ctx)) {
			$uri .= '?'.static::ctx_save($ctx);
		}
		if ($query) $uri = url::q_ext($uri, $query);
		return $uri;
	}


	/* * */


	static function call($name = true, $ctx = false, $ext = 'inc'){
		/*//ak buildPath|pathBuild($name, $ext)|pathWizard
		if ($name === true) $name = static::rpName(); /dx($name);
/
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