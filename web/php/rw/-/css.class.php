<?#0.1

class rw_css {



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


}