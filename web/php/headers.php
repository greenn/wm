<?#6.9.8     — про заголовки

_needphp('g', 't', 'isAssoc', 'x', 'fq');
//_needphp('lib'); _lib('kint'); //d($GLOBALS['_webphpIncludedOnce']);
_needphp('emu/getallheaders');

_addphp('rootLess');
_addphp('headers/etag');

//- d('fkd-dx');
/*

headers('css', 'utf8', array('cache' => array('until' => 'next sunday'));

headers('css', 'utf8', array('cache' => false));
headers('css', 'utf8', 'cache-on');
headers('css', 'utf8', 'cache-off');

headers('css', 'utf8', array('cache' => 0 ? array('until' => 'next sunday') : false));

*/
//[mb/jd use prefix |hs_|]
g('preventHeaders', 0); //[jd/rb x]
x('pendingHeaders', array()); //для контроля и личного использования / автоматически нигде не юзается
x('pendingETagCtx', array());
x('skipETagPending', false); //указание на пропуск добавления ETagCtx при инсертах (useTemplate) в pending очередь [pendingETagCtx]
x('usePendingETag', true); //добавление в ETagCtx pending очереди [pendingETagCtx]

//eg: add_etag_ctx(array(…))
function add_etag_ctx($ctx){ //mb use prefix |hs_|
	x_merge('pendingETagCtx', $ctx);
}

function prevent_headers(){
	gIncr('preventHeaders');
}


function headers(){

	$options = func_get_args();

	//dx(g('preventHeaders'), headers_sent(), get_defined_vars());

	if (headers_sent() || (g('preventHeaders') > 0)) {

		x_push('pendingHeaders', $options); //not-used, only for debug

		if (!x('skipETagPending')) {
			if ($etagCtx = etag::lookForCtx($options)) {
				x_merge('pendingETagCtx', $etagCtx);
				//dx($etagCtx, x('pendingETagCtx'));
			}
		}

		return;
	}

	//dx(g('preventHeaders'), $options);

	$headers = new Headers($options);

	if (x('usePendingETag')) {
		if ($ctx = x('pendingETagCtx')) {
			$opt = etag::ctxArg($ctx);
			$headers->setOption($opt);
		}
	}
	x('pendingETagCtx', array()); //reset
	x('pendingHeaders', array()); //reset

	$headers->apply();

	return $headers;
}


function headers_obj(){
	$options = func_get_args();
	$headers = new Headers($options);
	return $headers;
}

function headers_assoc(){
	$options = func_get_args();
	$headers = new Headers($options);
	return $headers->prepare_assoc();
}

function headers_upd(){}
function headers_off(){}


function headersData($type = false){
	static $valStack;
	static $optStack;

	if (!$optStack) $optStack = array(

	);


	if (!$valStack) $valStack = array(
		//'js' => "Content-Type: application/javascript",
		//'utf' => "charset=UTF-8",
		'txt' => array("Content-Type" => "text/plain"),
		'utf8' => array("Content-Type" => "charset=UTF-8"),
		'js' => array("Content-Type" => "application/javascript"),
		'css' => array("Content-Type" => "text/css"),
		'json' => array("Content-Type" => "application/json"),
		'html' => array("Content-Type" => "text/html"),
		'png' => array("Content-Type" => "image/png"),
		'ico' => array("Content-Type" => "image/x-icon"),
		'svg' => array("Content-Type" => "image/svg+xml"),
		//'xml' => array("Content-Type" => "text/xml"), //тоже самое что application/xml, но устаревшее
		'xml' => array("Content-Type" => "application/xml"),

		'nosniff' => array("X-Content-Type-Options" => "nosniff"),

		//cross-domain
		//'cross' => array("Access-Control-Allow-Headers" => "Content-Type, authorization"),


		//'304' => 'HTTP/1.1 304 Not Modified',
		'304' => array(
		    'HTTP/1.1 304 Not Modified' => '',
            ':cmd' => array('only' => 'HTTP/1.1 304 Not Modified', 'exitAfter' => true)
        ),


		'until' => array("Cache-Control" => "max-age=%s"), //~
		'max-age' => array("Cache-Control" => "must-revalidate, max-age=%s"),
		'rand_1-3h' => array("Cache-Control" => "public, max-age=".rand(1*60*60, 3*60*60)),

		'1h' => array(
			"Cache-Control" => "public",
			//"Expires" => date("r", time() + 3600)
			"Expires" => Headers::timeFormat(time() + 3600*4)
		),
		'cache-on' => array(
			"Cache-Control" => array("public", "must-revalidate")
		),
		'cache-off' => array(
			"Cache-Control" => array("no-cache", "no-store", "must-revalidate"),
			"Pragma" => "no-cache",
			"Expires" => "0", //date("r")
		),


		'cors-on' => array(
			"Access-Control-Allow-Origin" => "*",
			"Access-Control-Allow-Credentials" => "*",
			"Access-Control-Allow-Methods" => "*", //GET, POST, PUT, DELETE
			//"Access-Control-Allow-Headers" => "*", //Authorization, Content-Type
		),
	);
	return $type == 'opt' ? $optStack : $valStack;
}


//Hs
class Headers {

    static function timeFormat($timestamp){
        return gmdate('D, d M Y H:i:s T', $timestamp);
    }

    static function is304(/* headers options */){
        $headers = call_user_func_array('headers_obj', func_get_args());
        $headers304 = headers_obj('304');
        $match = $headers304->prepare_output() === $headers->prepare_output();
        return $match ? $headers : false;
    }

	var $stack = array();
		//может в стек класть не { название => значения },
		//а { заголовок => true|false }

	function __construct($options = null/*, $debug = null*/) {
	    //if (is_bool($debug)) etag::debug($debug);
		$this->setOptions($options);
	}

	function setOptions($stack){
		if (is_array($stack)) {
			foreach ($stack as $item) {
                if (is_string($item) && (strpos($item, '=') !== false)) {
                    list($prop, $val) = explode('=', $item, 2);
                    $item = array();
                    $item[$prop] = $val;
                }
				$this->setOption($item);
			}
			//dx($stack, $this->stack);
		}
	}

	static function merge_values($val1, $val2){ //r без-self-рекурсии
		$arr1 = is_array($val1) ? $val1 : false;
		$arr2 = is_array($val2) ? $val2 : false;
		//dx($arr1, $arr2);
		if ($arr1 && $arr2) {
			$res = array();
			foreach ($arr1 as $index => $data) {
				$value1 = is_array($data) ? $data : array($data);
				$res[$index] = $value1;
			}

			foreach ($arr2 as $index => $data) {
				$value2 = is_array($data) ? $data : array($data);

				if (isset($res[$index])) {
					$value1 = $res[$index];
					$res[$index] = array_merge($value1, $value2);

				} else {
					$res[$index] = $value2;
				}
			}

			return $res;
		}
		//else
		if ($arr1) return $arr1;
		if ($arr2) return $arr2;
		return array();
	}

	static function parseOption($data){
		switch(gettype($data)) {
			case 'string':
				return self::parseStringOption($data);

			case 'array':
				if (isAssoc($data)) {
					return self::parseAssocOption($data);
				}
				//else
				$res = array();
				foreach ($data as $item) {
					$itemRes = self::parseOption($item);
					$res = self::merge_values($res, $itemRes);
				}
				return $res;

			//default: //skip
		}

		return null;
	}

	static function parseStringOption($str){
		$res = array();
		$conf = headersData();
		if (isset($conf[$str])) {
			$res = $conf[$str];
		} else {
			//parse unknown string
			if (strpos($str, ':') !== false) {
				list($name, $value) = explode(":", $str, 2);
				$res[$name] = trim($value);
			} else {
				$res[$str] = '';
			}
		}
		return $res;
	}



	static function opt_cache($value){
		$conf = headersData();

		switch(gettype($value)) {
			case 'boolean':
				if ($value) {
					$data = prop($conf, 'cache-on');
				} else {
					$data = prop($conf, 'cache-off');
				}
				break;

			default:
				$data = self::parseOption($value);
		}
		return $data;
	}

	static function opt_until($value){
        //fetch `until` and add `cache-on`
	    /*
        $conf = headersData();

        $tValue = ts_until($value, true);
		$option = prop($conf, 'until');
        $optData = array();
		foreach ($option as $_name => $_value) {
			$optData[$_name] = sprintf($_value, $tValue);
		}

		$cacheData = prop($conf, 'cache-on');
		//$cacheData = $this->parseOption(array('cache' => 'cache-on'));

		$data = self::merge_values($cacheData, $optData);
		return $data;
		*/
        return self::merge_values(array(
            "Cache-Control" => sprintf("max-age=%s", ts_until($value, true))
        ), prop(headersData(), 'cache-on'));
	}

    static function opt_max_age($max_age){
        return self::merge_values(array(
            "Cache-Control" => sprintf("max-age=%s", $max_age) //must-revalidate, / no-cache, must-revalidate,
        ), 0&& prop(headersData(), 'cache-on'));
    }


    //private
	static function parseAssocOption($assoc){
		$res = array();
		$conf = headersData();
		foreach ($assoc as $name => $value) {
			$data = false;

			switch ($name) {
				case 'cache':
					$data = self::opt_cache($value);
					break;

				case 'until':
					$data = self::opt_until($value);
					break;

                case 'max-age':
                    $data = self::opt_max_age($value);
                    break;

				case 'etag_file':
					$data = etag::opt(array('autofile' => array('path' => $value)));
					//dx($data, self::merge_values($res, $data));
					break;

                case 'etag_ctx':
                    $data = etag::opt(array('ctx' => $value));
                    //dx($data, self::merge_values($res, $data));
                    break;

				case 'etag': //- //[tm]
					dx('parse `etag`', $value);
					$data = etag::opt($value);
					break;

				default:
					$data[$name] = $value;
			}

			if (!empty($data)) {
				$res = self::merge_values($res, $data);
			}

		}
		return $res;
	}


	//function delOption(){}

	function setOption($conf){
		$data = $this->parseOption($conf);
		//d($conf, $data, self::merge_values($this->stack, $data));
		if (empty($data)) return;

		$this->stack = self::merge_values($this->stack, $data);
	}

	var $set = array(); //[mb private]
	private function prepare_stack(){
        $stack = $this->stack;
        if (isset($stack[':cmd'])) {
            $cmd = $stack[':cmd'];
            unset($stack[':cmd']);

            if ($only = prop($cmd, 'only')) {
                //[td] if (is_array($only));
                $stack = make_arr($only, prop($stack, $only));
            }
            if (has_prop($cmd, 'exitAfter')) {
                $this->set['exit'] = true;
            }

        }
        return $stack;
    }

	var $valuesGlue = '; '; #¦'; '¦', '¦"\n"¦
		# , https://stackoverflow.com/questions/3096888/standard-for-adding-multiple-values-of-a-single-http-header-to-a-request-or-resp
		# ; https://stackoverflow.com/questions/35761248/which-separator-should-be-used-in-the-content-type-header-for-a-multipart-data-r
	function prepare_output(){
		$headers = array();
        $stack = $this->prepare_stack();
        //dx($stack, $this->set);
		foreach ($stack as $name => $values) {
			if (!is_array($values)) $values = array($values);
			if ($values === array('')) $values = array();
			$value = empty($values) ? '' : sprintf(': %s', join($this->valuesGlue, $values));
			$header = sprintf('%s%s', $name, $value);
			$headers []= $header;

			//byOne
			//foreach ($values as $value) { $header ="$name: $value"; $headers []= $header; }
		}
		return $headers;
	}

	function prepare_assoc(){
		$headers = array();
        $stack = $this->prepare_stack();
		foreach ($stack as $name => $values) {
			if (!is_array($values)) $values = array($values);
            if ($values === array('')) $values = array();
			$value = empty($values) ? '' : join($this->valuesGlue, $values);
			$headers[$name] = $value;
		}
		return $headers;
	}

	function apply(){
	    $output = $this->prepare_output();
	    //dx($output, headers_sent(), x('pendingETagCtx'), x('pendingHeaders'));
		$this->setLast($output);
		foreach ($output as $header) {
		    $header = preg_replace('~[\r\n]~', '*', $header); //for debug-on
			header($header, true);
		}
		//reset PendingContext
		//x('pendingHeaders', array());
		//x('pendingETagCtx', array());
		if (prop($this->set, 'exit')) exit;
	}

	private function setLast($output) {
		self::$rawLast = $output;

	    $stack = array();
        //d($output);
	    foreach ($output as $line) {
            $vals = explode(': ', $line, 2);
	        $stack += make_arr($vals[0], prop($vals, 1, ''));
        }
        return self::$last = $stack;
    }
    static $last;
    static $rawLast;
	static function last($name = false, $otherwise = false) {
	    $value = self::$last;
	    if ($name) $name = prop(array(
	        'etag' => 'Etag'
        ), $name, $name);
	    return $name ? prop($value, $name, $otherwise) : $value;
    }
    static function lastModified($pattern = true, $otherwise = false) {
        $res = $otherwise;
	    if ($pattern === true) $pattern = 'y/m/d\'H:i:s';
        if ($value = self::last('Last-Modified')) {
            $res = date($pattern, strtotime($value));
        }
        return $res;
    }
    static function lastEtagInfo($outPattern = ' (%s¦%s)', $timePattern = true){
	    return sprintf($outPattern, Headers::last('Etag'), Headers::lastModified($timePattern));
    }
    static function cacheRequest($mode = 1, $returnStack = false){
        $skipHeaders = array(
            'Host',
            'Connection',
            'Content-Length',
            'Accept',
            'Accept-Encoding',
            'Accept-Language',
            'Origin',
            'X-Requested-With',
            'Content-Type',
            'Referer',
            'X-Compress',
            'Upgrade-Insecure-Requests',
            'User-Agent',
            'Pragma',
            'Cookie',
            //'Cache-Control',
            //'If-None-Match',
            //'If-Modified-Since',
        );
        $cacheHeaders = array(
            'Cache-Control',
            //'Pragma',
            'If-None-Match',
            'If-Modified-Since',
        );

        $headers = array();
        foreach (getallheaders() as $name => $value) {
            if ($mode == 2) {
                if (!in_array($name, $skipHeaders)) {
                    $headers[$name] = $value;
                }
            } elseif ($mode == 3) {
                $headers[$name] = $value;
            } else {
                if (in_array($name, $cacheHeaders)) {
                    $headers[$name] = $value;
                }
            }
        }

        if ($returnStack) {
            $stack = array();
            foreach ($headers as $name => $value) {
                $stack []= "$name: $value";
            }
            $headers = $stack;
        }

        return $headers;
    }
}


/* 1
	хендлер
	для работы с заголовками

	в идеале
		перезапись
		снятие
		добавление



just id
	headers('utf8 css cache-on until next sunday'); // -

*/


function clear_sent_headers(){
	if (!headers_sent()) {
		foreach (headers_list() as $header) {
			header_remove($header);
		}
	}
}