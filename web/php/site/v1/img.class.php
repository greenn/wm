<?#2.4.1

_needphp('fq/attr.class');

class _img {
	static $dir = '';
	static $host = hostUrl;
	static $hostUrl = false;

	static function name($relName, $leadingSlash = false){
		$name = (static::$dir ? static::$dir.'/' : '').$relName;
		return ($leadingSlash ? '/' : '') . ltrim($name, '/');
	}
	static function path($relName){
		static $dir = false;
		if (!$dir) {
			$dir = ROOT.(static::$dir ? '/'.static::$dir : '');
		}
		//dx($dir);
		return $dir.'/'.$relName;
	}

	static function has($relName){
		$path = static::path($relName);
		return is_file($path);
	}

	static function size($relName){
		static $cache = array();
		$path = static::path($relName);


		if (!isset($cache[$path])) {
			$cleanPath = strtok($path, '?');
			$cache[$path] = getimagesize($cleanPath);
		}

		$data = $cache[$path];
		return array(
			'w' => prop($data, 0),
			'h' => prop($data, 1),
		);
	}
	static function w($relName){
		$size = static::size($relName);
		return $size['w'];
	}
	static function h($relName){
		$size = static::size($relName);
		return $size['h'];
	}

	static $skipHostVerify = false;
	static function uri($relName/*, $skipHostVerify = false*/){
		//вставка, для использования субдоменов, когда система лежит на одном

		$skipHostVerify = func_num_args() > 1 ? func_get_arg(1) : static::$skipHostVerify;

		if (!$skipHostVerify) {
			$useHostUri = static::$hostUrl;
			if (!$useHostUri) {
				$normalizedRoot = str_replace('\\', '/', ROOT);
				$normalizedServerRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
				$useHostUri = $normalizedRoot !== $normalizedServerRoot;
			}
			//dx($skipHostVerify, $relName, static::$hostUrl, ROOT, $_SERVER['DOCUMENT_ROOT']);
			if ($useHostUri) {
				return static::hostUri($relName);
			}
		}

		$path = static::path(ltrim($relName, '/'));
		$uri = fileUrl($path, true, ROOT);
		//if ($query) $uri = url::q_ext($uri, $query);
		return $uri;
	}
	static function hostUri($relName){
		return static::$host.static::uri($relName, true);
	}

	static function data($relName){
		$data = static::size($relName);
		$data['has'] = static::has($relName);
		$data['uri'] = static::uri($relName);
		$data['path'] = static::path($relName);
		return $data;
	}

	static function img($relName, $ad = '', $style = ''){
		$as = attr::asd(
			array('loading="lazy"'), //default
			$ad,
			$style ? ' style="'.$style.'"' : ''
		);
		$uri = static::uri($relName);

		/*$isRawName = is_array($relName);
		if ($isRawName) {
			$uri = join('/', $relName);
		} else {
			//case base
			$uri = static::uri($relName);
		}*/
		return '<img src="'.$uri.'" '.$as.'/>';
	}


	static function svg($svgRelName){
		$cache = array();
		if (!isset($cache[$svgRelName])) {
			$path = static::path($svgRelName);
			$cache[$svgRelName] = file_get_contents($path);
		}
		return $cache[$svgRelName];
	}
}


class _i extends _img {
	static $dir = 'i';
}