<?#1.2.0

/*
	eg
		$list = dirToArray::apply(array(
			'path' => static::$cacheDir,
			'keepDots' => false,
			'depth' => -1,
		));

td
	justFiles
*/

_needphp(
	'set',
	'str/endsWith',
	'str/startsWith'
);

class dirToArray {

	static function decode_iconv($path, $in_charset = 'Windows-1251', $out_charset = 'UTF-8'){
		return iconv($in_charset, $out_charset, $path);
	}



	static function apply($set, $depth = false){
		if (is_string($set)) $set = array('path' => $set);
		$set = set(array(
			'path' => null,
			'decodeSrcPath' => false,
			'depth' => -1,
			'keepDots' => true,
			'decoder' => array('Windows-1251', 'UTF-8'),
			'decodeName' => false,
			'decodePath' => false,

			//'encoding_method' => 'iconv',
			//'encoding' => 'Windows-1251',
			/*для этого понадобится наверное dirToArray{}
				также будет возможно внесение доп. настроек
				filter и прочее
					для пропуская каких-нибудь файлоы, типа 'desktop.ini'
			*/

			//'just-files' => false, >> fileList
			//'filter-ext' => array('svg'), >> filterByExt
		), $set);
		if (is_integer($depth)) $set->depth = $depth;

		$listPath = array();

		if ($set->decodeSrcPath) {
			$set->path = dirToArray::decode_iconv($set->path, $set->decoder[1], $set->decoder[0]);
		}
		$pathDir = realpath($set->path);
		//if (func_num_args() === 2) dx($pathDir);

		if (is_dir($pathDir)) {

			$listNames = scandir($pathDir);

			foreach ($listNames as $index => $name) {
				#- $name = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($name));
				#- $name = mb_convert_encoding($name, "UTF-8", "auto");
				#~ $name = utf8_encode($name);
				#+ $name = iconv("Windows-1251", "UTF-8", $name);

				$saveName = $name;
				if ($set->decodeName) {
					$saveName = dirToArray::decode_iconv($name, $set->decoder[0], $set->decoder[1]);
				}

				if ($selfDirectory = $name == '.') {
					if ($set->keepDots) $listPath[$saveName] = $pathDir . DIRECTORY_SEPARATOR;
				} elseif ($parentDirectory = $name == '..') {
					if ($set->keepDots) $listPath[$saveName] = dirname($pathDir) . DIRECTORY_SEPARATOR;
				} else {
					$path = $pathDir . DIRECTORY_SEPARATOR . $name;

					if (is_dir($path)) {
						//d('is-dir', $set->depth, $set->info(), $path);
						if ($set->depth) {
							$_set = $set->cloneData(false, array('path' => $path, 'decodeSrcPath' => false));

							$listPath[$saveName] = dirToArray::apply($_set, $set->depth - 1);
							//dx($set->info(), $set->depth, $listPath[$saveName]);
						} else {
							//$listPath[$name . DIRECTORY_SEPARATOR] = $path;
							$listPath[$saveName] = $path . DIRECTORY_SEPARATOR;
						}

					} else {
						$listPath[$saveName] = $path;
					}

					//dx($set->decodePath);
					if ($set->decodePath && is_string($listPath[$saveName])) {
						$listPath[$saveName] = dirToArray::decode_iconv($listPath[$saveName], $set->decoder[0], $set->decoder[1]);
					}
				}

			}

		}

		return $listPath;
	}

	static function fileList($data, $relName = true){
		$res = array();
		foreach ($data as $name => $content) {
			if ($relName) {
				if ($relName !== true) {
					$name = "$relName/$name";
				}
			}
			if (is_array($content)) {
				//dx('filterByExt-before-recursion', $content);
				$res += static::fileList($content, $name);
			} else {
				$res[$name] = $content;
			}
		}
		return $res;
	}

	static function filter($list, $cb, $depth = 0){
		$res = array();
		if (is_callable($cb)) {
			foreach ($list as $name => $data) {
				if (is_array($data)) { //case: $data = $subList
					$subRes = static::filter($data, $cb, $depth + 1);
					if ($subRes) {
						$res[$name] = $subRes;
					}
				} else {
					if ($cb($name, $data, $depth)) {
						$res[$name] = $data;
					}
				}
			}
		}
		return $res;
	}

	static function exclude($list, $cb){
		return static::filter($list, function($name) use ($cb) {
			return !call_user_func_array($cb, func_get_args());
		});
	}

	static function filterByExt($data, $ext){
		if (!is_array($data)) $data = static::apply($data);
		//d('filterByExt', func_get_arg(0), $data);
		$res = array();
		foreach ($data as $name => $content) {
			if (is_array($content)) {
				//dx('filterByExt-before-recursion', $content);
				$content = static::filterByExt($content, $ext);
				if ($content) {
					$res[$name] = $content;
				}
			} else if (endsWith($name, $ext)) {
				$res[$name] = $content;
			}
		}
		return $res;
	}


	static function excludePath($data, $exclude, $subPath = ''){
		if (!is_array($data)) $data = static::apply($data);
		//d('filterByExt', func_get_arg(0), $data);
		$res = array();
		foreach ($data as $name => $content) {
			if (is_array($content)) {
				//dx('excludePath-before-recursion', $content);
				$content = static::excludePath($content, $exclude, $name);
				if ($content) {
					$res[$name] = $content;
				}
			} else {
				$relName = $subPath ? "$subPath/$name" : $name;
				$baseName = basename($name, '.' . pathinfo($name, PATHINFO_EXTENSION));

				$skip = false;
				foreach ($exclude as $rule => $vals) {
					if (!is_array($vals)) $vals = (array) $vals;
					foreach ($vals as $val) {
						if ($skip) continue;
						//dx($rule, $val, $name, $subPath, $content, $relName, $baseName);
						switch ($rule) {
							case 'skip': {
								if ($relName === $val) $skip += true;
							} break;
							case 'ext': {
								//d($relName, endsWith($name, $val), $name, $val);
								if (endsWith($name, $val)) {
									$skip += true;
								}
							} break;
							case 'startsWith': {
								if (startsWith($name, $val)) {
									$skip += true;
								}
							} break;
							case 'endsWith': {
								if (endsWith($baseName, $val)) {
									$skip += true;
								}
							} break;
							case 'dirs': {
								//dx($rule, $val, $subPath, $data, $name, $content);
								if ($val) if (is_dir($content)) {
									$skip += true;
								}
							} break;
							case 'files': {
								//dx($rule, $val, $subPath, $data, $name, $content);
								if ($val) if (!is_dir($content)) {
									$skip += true;
								}
							} break;
						}
					}
				}

				if (!$skip) {
					$res[$name] = $content;
				}
			}
		}
		return $res;
	}

	//создать одноуровненый стек с относительными именами
	//называется flat
	static function makeRelStack($data, $subDir = ''){
		$res = array();
		if (!is_array($data)) $data = static::apply($data);
		foreach ($data as $name => $content) {
			$relName = $subDir ? "$subDir/$name" : $name;
			if (is_array($content)) {
				$res += static::makeRelStack($content, $relName);
			} else {
				$res[$relName] = $content;
			}
		}
		return $res;
	}

	//eg echo '<pre>', dirToArray::makeListing($fileList), '</pre>';
	static function makeListing($data){
		return join(newline, array_keys(static::makeRelStack($data)));
	}
}
