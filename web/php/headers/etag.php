<?#5.8

_needphp('getCaller', 'isAssoc');
//_needphp('fq/_props');

define('CACHE_ETAG_DEBUG', false);
define('CACHE_ETAG_PEPPER', defined('SITE_ETAG_PEPPER') ? SITE_ETAG_PEPPER : false);

//[tt /web/test/php/headers/etag.php]
class etag {
    static function pepper (){
        static $value = CACHE_ETAG_PEPPER;
        if (func_num_args() === 1) {
            $value = func_get_arg(0);
        }
        return $value === true ? microtime(true) : $value;
    }

    static function opt($value){

		$data = array();
		if (is_array($value)) {
			foreach ($value as $type => $conf) {
				$addData = array();
				switch ($type) {
					case 'autofile':
						$path = prop($conf, 'path');
						if ($path && is_file($path)) {
							$addData = self::autofile($path);
						}
						break;
                    case 'ctx':
                        $addData = self::byCtx($conf);
                        break;
				}
				if (!empty($addData)) {
					$data = Headers::merge_values($data, $addData);
				}

			}
		}
		return $data;
	}
	
	static function debug(){
        static $value = CACHE_ETAG_DEBUG;
        if (func_num_args() === 1) {
            $value = func_get_arg(0);
        }
        return $value;
    }

	static $debug_timePattern = 'y-m-d H:i:s[u]';
    static function debug_timeFormat($timestamp, $pattern = true){
        if ($pattern === true) $pattern = self::$debug_timePattern;
        return udate($pattern, $timestamp);
    }
	
	static function value_debug($path = true, $version = true, $domain = true){
		if ($path === true) $path = getCaller('path');
		if ($version === true) $version = udate(self::$debug_timePattern);
		else $version = self::debug_timeFormat($version);
		if ($domain === true) $domain = domain;

        $pathStack = is_array($path) ? $path : array($path);
        foreach ($pathStack as &$path) {
            $path = ltrim(rootLess($path), DIRECTORY_SEPARATOR);
            $path = str_replace(DIRECTORY_SEPARATOR, '-', $path);
            if (preg_match('~^[\w\d]{8}$~', $path)) { //case: is hash # https://regex101.com/r/4IYDQv/1/
                $path = print_r(self::extraHash($path), true);
            }
        }
        $path = "\r\n".join("\r\n", $pathStack)."\r\n";
        $path = sprintf('{%s}', $path);

		$etag = sprintf('%s-%s-%s', $domain, $path, $version);
        if (self::pepper()) $etag .= '-перчик['.self::pepper().']';
		return $etag;
	}

	static function value($path = true, $version = true, $domain = true, $debugMode = null){
		if (is_null($debugMode)) $debugMode = self::debug();
		if ($debugMode) return self::value_debug($path, $version, $domain);

		if ($path === true) $path = getCaller('path');
		if ($version === true) $version = microtime(true);
		if ($domain === true) $domain = domainUrl;

        if (is_array($path)) $path = join('¦', $path);

		$etag = sprintf('%s-%s-%s', hash('adler32', $domain), hash('adler32', $path), hash('adler32', $version));
		if (self::pepper()) $etag .= '-'.hash('adler32', self::pepper());
		return $etag;
	}


    static function verifyRequestHeaders($etag, $last_modified){
        // Last-Modified на клиенте
        $modified_since = isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) ? strtotime($_SERVER["HTTP_IF_MODIFIED_SINCE"]) : false;

        // ETag на клиенте
        $cachedETag = isset($_SERVER["HTTP_IF_NONE_MATCH"]) ? trim($_SERVER["HTTP_IF_NONE_MATCH"]) : false;

        if ($modified_since === $last_modified && $etag === $cachedETag) {

            $data = Headers::parseOption('304');

        } else {
            //set last-modified header
            $data = array();
            $data['Last-Modified'] = Headers::timeFormat($last_modified);
            $data['Etag'] = $etag;
        }
        return $data;
    }

    static function get_file_modified($path, $otherwise = 0){
        $tmp = realpath($path) ? filemtime($path) : $otherwise;
        return $tmp;
    }

	static function basedOnFile($filePath, $useDetailedResponse = false){ //ofFile
		$last_modified = self::get_file_modified($filePath);
		$etag = self::value($filePath, $last_modified);

		return !$useDetailedResponse ? $etag : array(
			0 => $etag,
			1 => $last_modified,
			'etag' => $etag,
			'last_modified' => $last_modified,
		);
	}

	static function autofile($filePath){
		$fileEtag = self::basedOnFile($filePath, true);
        $data = self::verifyRequestHeaders($fileEtag['etag'], $fileEtag['last_modified']);
		return $data;
	}


	static function byCtx($data/*, $debug = false*/){
        //d($data);

	    if (isAssoc($data)) {
	        $newData = array();
	        foreach ($data as $prop => $value) {
                $newData []= make_arr($prop, $value);
            }
            $data = $newData;
        }

        //d($data);
        $newData = array();
        foreach ($data as $index => $item) {
            if ($ctxData = prop_hit($item, array('etag_ctx', 'ctx'))) {
                $newData = array_merge($newData, $ctxData);
            } elseif ($fileData = prop($item, 'etag_file')) {
                $newData []= $fileData;
            } else {
                $newData []= $item;
            }
        }
        $data = $newData;
        //dx($data);


	    $ctx = array(); //items
        foreach ($data as $index => $item) {
            if (is_string($item)) $item = array('file' => $item);
            //elseif (!is_array($item)) $item = self::extra($item);
            $ctx []= $item;
        }

        $pathStack = array();
        $late_last_modified = 0;
        foreach ($ctx as $index => $conf) {
            if ($file = prop_hit($conf, array('file', 'etag_file'))) {
                $file_modified = self::get_file_modified($file, '--');
                $pathStack []= sprintf(
                    '(%s):%s',
                    self::debug() ? self::debug_timeFormat($file_modified, 'H:i:s y/m/d') : $file_modified,
                    rootLess($file)
                );
                if ($file_modified > $late_last_modified) {
                    $late_last_modified = $file_modified;
                }
            } elseif ($extra = prop($conf, 'extra')) {
                $pathStack []= $extra;
            } else {
                if (self::debug()) d('etag-ctx-unknown-data', $conf);
            }
        }

        $etag = etag::value($pathStack, $late_last_modified);

        $data = self::verifyRequestHeaders($etag, $late_last_modified);

        /*if (!$debug) {
            $data = self::verifyRequestHeaders($etag, $late_last_modified);
        } else {
            $data = array(
                'Last-Modified' => Headers::timeFormat($late_last_modified),
                'Etag' => $etag
            );
        }*/

        return $data;
    }

    static $extraHashes = array(); //buildExtraHistory|extraHashes|
    static function extraHash($hash){
        return prop(self::$extraHashes, $hash, $hash);
    }
    static function extra(){
	    $args = func_get_args();
	    $hash = hash('adler32', json_encode($args));

        self::$extraHashes[$hash] = $args;
        //dx($hash, self::$extraHashes);
        return array('extra' => $hash);
    }
    static function ctx(){
        $args = func_get_args();
        return self::ctxArg($args);
    }
    static function ctxArg($ctx){
        return array('etag_ctx' => $ctx);
    }
    static function file($path = true){
        if ($path === true) $path = getCaller('path');
        return array('etag_file' => $path);
    }

    //попытка найти etagCtx в пришедщих данных
    static function lookForCtx($data){
    	$res = false;
    	if (is_array($data)) {
    		$found = array();
    		//dx(isOrdinal($data), $data);
		    if (isOrdinal($data)) {
			    foreach ($data as $index => $item) {
				    //if (isOrdinal($item)) { $ctx = lookForCtx($item); }
				    if ($ctx = prop($item, 'etag_ctx')) {
				    	//dx($ctx, $item);
					    //$found []= $ctx;
					    //$found []= $item;
					    $found = array_merge($found, $ctx);
				    }
			    }
			    //dx($res);
		    }
		    if (!empty($found)) {
		    	//$res = count($found) > 1 ? $found : $found[0];
		    	//dx($found, $res);
			    $res = $found;
		    }
	    }
    	return $res;
    }
}