<?#0.1

class rw_file {


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

}