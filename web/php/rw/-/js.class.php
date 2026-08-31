<?#0.1

class rw_log {



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


}