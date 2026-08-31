<?#0.1

class rw_data {



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


}