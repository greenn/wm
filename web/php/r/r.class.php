<?#5.15.18
_needphp('getCaller');

define('R_BASE', 'base');
define('R_RELATIVE', 'relative');

define('rDir', 'r'); //0h
define('rPath', ROOT.'/'.rDir); //1

class R {

    var $options = array(
        'relative' => true,
        //'rBase' => rPath
    );
    //взаимоисключающие опции
    private $mutualOptions = array(
        array(R_BASE, R_RELATIVE)
    );

    private $pathPattern;

    var $c; //class object
    private $cc; //call config

    var $name; # resource name
    var $dir; # resource directory path

    var $var; # name variable
    var $uri; # resource directory root-relative url
    var $url; # resource directory full url
    var $rName; # resource path name
    var $vName; # resource variable name

    var $jn; # resource json-data-interface name

    //0-
    var $declUri; //относительная ссылка на дклорацию
        //при использовании через rPath() добавляет в неё qv

    var $declPath; //прямая ссылку на декларацию

    //computing by method calls
    var $isTestPage; #::: RC->isTestPage()


    //[rb] function __construct($filePath = false, $options, $data){
    function __construct($filePath = false/*, options, ...*/){
        //d('r:', $filePath, func_get_args());

        //auto-rPath
        if (!$filePath) {
            $filePath = getCaller('path'); //getCaller('path', 'r')
        }

        if (func_num_args() > 1) {
            $options = func_get_args();
            array_shift($options);
            $this->handleOptions($options);
        }

        //auto-rBase
        if (!$this->opt('rBase')) {
            $this->optSet('rBase', ROOT);
            $this->optSet(R_RELATIVE);
        }

        $this->locate($filePath);
    }


    function handleOptions($optionsStack){
		foreach ($optionsStack as $option) {
			if (is_array($option)) {
				foreach ($option as $name => $value) {
					$this->optSet($name, $value);
				}
			} else {
				$this->optSet($option, true);
			}
		}


		///$this->setRDir();
	}

	function opt($name, $otherwise = null){
		return isset($this->options[$name]) ? $this->options[$name] : $otherwise;
	}

	function optSet($name, $value = true){
		//$hasVal = func_num_args() == 2;

		$this->options[$name] = $value;

		//проверка взаимоисключающих опций
		foreach ($this->mutualOptions as $mutual) {
			if (in_array($name, $mutual)) {
				foreach ($mutual as $option) {
					if ($option !== $name) {
                        $reverseValue = !$value;
						$this->options[$option] = $reverseValue;
					}
				}
			}
		}

	}


	function locate($filePoint){
        //d("locate-0:$filePoint");
        //d($filePoint, realpath($filePoint), !is_file($filePoint), !is_dir($filePoint), !is_file($filePoint) || !is_dir($filePoint));

        if (!is_file($filePoint) && !is_dir($filePoint)) {
            //$filePoint = ROOT.'/'.rDir.'/'.trim($filePoint, '/');
            $filePoint = $this->opt('rBase', ROOT).'/'.trim($filePoint, '/');
            //d("locate-1:$filePoint");
        }

        $filePoint = realpath($filePoint);
        if (is_dir($filePoint)) $filePoint .= DIRECTORY_SEPARATOR;
        //if (!$filePoint) return;

        if (!$this->pathPattern) $this->setPattern();

        $name = $this->get_name($filePoint);

        if ($name) {
            $this->setName($name);
        }
    }

	function setPattern(){
		$pattern = $this->opt('rBase', ROOT).'/%s';
		//d($pattern);

		if (osLinux) {
			$pattern = preg_quote(str_replace('\\', '/', $pattern));
			if ($this->opt('base')) {
				$pattern = sprintf($pattern, '([^/]+)/'); # начальный cmpt
				# $pattern = sprintf($pattern, '([^/]+)/?');
			}
			if ($this->opt('relative')) {
				$pattern = sprintf($pattern, '(.+)/.*$'); # относительный cmpt
				# $pattern = sprintf($pattern, '(.+)/?.*$');
			}

		}
		if (osWindows) { # https://regex101.com/r/hoXPcV/2
			$pattern = preg_quote(str_replace('/', '\\', $pattern));
			if ($this->opt('base')) {
				$pattern = sprintf($pattern, '([^\\\\]+)\\\\'); # начальный cmpt
				# $pattern = sprintf($pattern, '([^\\\\]+)\\\\?');
			}
			if ($this->opt('relative')) {
				$pattern = sprintf($pattern, '(.+)\\\\.*$'); # относительный cmpt
				# $pattern = sprintf($pattern, '(.+)\\\\?.*$');
			}


		}

		$this->pathPattern = $pattern;
	}


	function get_name($path){
		$name = null;
		if (is_array($path)) return $this->parse_name($path);

		if (preg_match("~^{$this->pathPattern}~", $path, $matches)) {
			$name = str_replace('\\', '/', $matches[1]);
		}
		//d($name, $path, $this->pathPattern, $matches);
		return $name;
	}

    //r - rPath
    //wr - wrPath
    function parse_name($conf){
        $name = null;
        if ($rName = prop($conf, 'r')) {
            $rPath = rPath."/$rName";
            if (is_dir($rPath)) {
                $name = $rName;
            }
        }
        return $name;
    }

    static function varName($data) {
        $string = (string) $data;
        $alignedString = str_replace(
            array('\\', '.'),
            array('/', ''),
            $string
        );
        $chunks = explode('/', $alignedString);
        $alignedChunks = array_map('camelize', $chunks);
        $resString = implode('_', $alignedChunks);
        return $resString;
    }
    private function setName($name){
        $this->name = $name;
        $this->dir = $this->opt('rBase', ROOT).'/'.$name;

        $this->var = self::varName($this->name);
        $this->rName = ltrim(rootLess($this->dir), '/');
        $this->vName = self::varName($this->rName);

        //$this->jn = "r::{$name}";
        $this->jn = "root::{$this->rName}";

        $this->uri = fileUrl($this->dir);
        $this->url = hostUrl.$this->uri;
    }

    //установка resource-path-with-declaration
    static $RPATH_DECL_DELIMETER = ':';


    function declPath($rUri, $uv = false){
        $declUri = $uv ? $this->qv($rUri) : $rUri;
        $declPath = $this->rName .self::$RPATH_DECL_DELIMETER . $declUri;
        return $declPath;
    }


    function relRPath($prName, $declName = true){
        if ($declName === true) $declName = ':api/decl';
        $prDecl = $this->rName($prName);
        $prDecl .= $declName;
        //dx($prDecl);
        return $prDecl;
    }

    function rPath($asCmptPath = true){
        $S = self::$RPATH_DECL_DELIMETER;
        if ($this->declPath) $rPath = $this->declPath;
        elseif ($this->declUri) $rPath = $this->declPath($this->declUri);
        else {
            $rPath = $this->rName;
            $tryNames = array();
            if ($rf = $this->filename) $tryNames []= "$rf.decl.json.php";
            $tryNames []= 'decl.json.php';
            $tryNames []= 'decl.json';
            foreach ($tryNames as $name) if (is_file($this->dir($name))){
                 $rPath .= $S.$name;
                 break;
            }
        }
        if (!$asCmptPath) $rPath = str_replace($S, '/', $rPath);
        return $rPath;
    }



    //attach Resource Class
    function attachClass($obj, $callConfig = array()){
        $this->c = $obj;
        $this->cc = $callConfig;
    }

	function initAutoClass($set = null){
		$classObj = new RC();
		$classObj->r($this);
		$this->attachClass($classObj);
		return $this;
	}

	function initClass($cFilename = null){
		$resObj = $this;

		$cPath = null;

		if (!$cFilename) {
			$cFilename = $this->name;
		} else {
			if (is_file($cFilename)) {
				$cPath = $cFilename;
			}
		}

		if (!$cPath) {
			$cPath = $this->dir($cFilename.'.r.inc'); //'%s.r.inc'
		}



		if ($cPath && is_file($cPath)) {
			//applyClass

			$cConf = inc($cPath, INC_RES_AS_ARRAY);

			if ($cConf) {
				$classObj = null;

				//choose createMethod
				//  with Class
				if ($ocName = prop($cConf, 'objClass')) {
					$ocArgs = array();
					$OC = new ReflectionClass($ocName);
					$classObj = $OC->newInstanceArgs($ocArgs);

				}
				//  with Function
				if ($ofName = prop($cConf, 'objFunction')) {
					$ofArgs = array();
					$classObj = call_user_func_array($ofName, $ofArgs);
				}


				if (is_subclass_of($classObj, 'RC')) {
					$classObj->r($this); // передаём в объект ссылку на свой r-инстанс
				}


				if (prop($cConf, 'replaceWith')) {
					$resObj = $classObj;
				} else {
					$this->attachClass($classObj, $cConf);
				}

			}


			//if (prop($cConf, 'replaceWith')) {}
			//dx($cPath, is_callable('rCP_html'), class_exists('rCP'));

		}

		return $resObj;
	}

    var $API = null;
    function apiConnect($set = null, $opts = array('replyType' => 'json')){
        _needphp('api');
        x('r', $this);

        $def = array(
            'pathStart' => $this->rName('api'), // [n ещё есть $r->uri --с ведущим /]
            'dirPath' => $this->dir('api'),
            'configSubPath' => 'api.conf.inc'
        );

        //dx($def);

        $set = is_array($set) ? array_merge($def, $set) : $def;
        $this->API = new API($set, $opts);
    }
    function api($method, $path, $data = true, $opts = null, $extCtx = null){
        x('r', $this);
        return api($method, $path, $data, $this->API, $opts, $extCtx);
    }

    function apiReply(){
        $api = $this->API;
        //dx($api->config);
        if ($api) {
            $api->setOpt('cacheVerify'); //qo
            //dx($api);
            x('r', $this);
            //usleep(500000); //.5s
            $api->run();

            if (gt_has('plain')) {
                $api->reply_plain();
            } else {
                $api->reply_json();
            }
        }
    }

    function extendStr($prop, $extendValue = null, $extendGlue = '/'){

        $value = isset($this->{$prop}) ? $this->{$prop} : '';

        if ($extendValue) {
            if (is_array($extendValue)) {
                $extendValue = join($extendGlue, $extendValue);
            } //else $extendValue = ltrim($extendValue, $extendGlue);

            $extendValue = sprintf('%s%s', $extendGlue, $extendValue);
        } else {
            $extendValue = '';
        }

        $res = sprintf('%s%s', $value, $extendValue);

        return $res;

    }

    function dirLess($path = true, $addToDir = false, $toTrim = true){
        _needphp('strLess');
        if (is_bool($path)) $path = getCaller($path ? 'dir' : 'path', 'dirLess');
        $res = pathLess($path, $this->dir($addToDir));
        return $toTrim ? trim($res, DIRECTORY_SEPARATOR) : $res;
    }
    function dirLessUrl($path = true, $addToDir = false, $toTrim = true){
        _needphp('strLess');
        if (is_bool($path)) $path = getCaller($path ? 'dir' : 'path', 'dirLessUrl');
        $res = pathLess($path, $this->dir($addToDir));
        $res = strtr($res, '\\', '/');
        return $toTrim ? trim($res, '/') : $res;
    }

    //static $dbgNocthTpl = "%date %notch%testPage\r\n%headers";
    static $dbgNocthTpl = array(" %date %notch%testPage", '%headers', '%request');
    static $dbgNocthDate = "y/m/d H:i:s";
    static $dbgNocthWraps = array(
        0 => array('', "\r\n", ''),
        'str' => array('', " ", ''),
        'css' => array("/*\r\n", "\r\n", "\r\n*/\r\n"),
        //'js' => array('// ', "\r\n//", ''),
        'js' => array("/*\r\n", "\r\n", "\r\n*/\r\n"),
        'html' => array("<!--/*\r\n", "\r\n", "\r\n*/-->\r\n")
    );
    var $dbgNotch = isMe;
    function dbgNotch($wrap = false, $pattern = true, $datePattern = true){
        if (!$this->dbgNotch) return '';
        $wrap = prop(self::$dbgNocthWraps, $wrap, self::$dbgNocthWraps[0]);
        if ($pattern === true) $pattern = self::$dbgNocthTpl;
        if ($datePattern === true) $datePattern = self::$dbgNocthDate;
        $_tpl = is_array($pattern) ? $pattern : array($pattern);

        foreach ($_tpl as &$tpl) {
            $tpl = strtr($tpl, array(
                '%testPage' => ($this->isTestPage ? ' TP': ''),//." ".($this->dbgNotch ? '`d' : '').(isMe ? '`m' : ''),
                '%notch' => '['.notch().']',
                '%date' => date($datePattern),
                '%headers' => Headers::lastEtagInfo('(%2$s¦%1$s)', $datePattern),
                '%request' => join(';'.$wrap[1], Headers::cacheRequest(2, true)),
            ));
        };

        return $wrap[0].join($wrap[1], $_tpl).$wrap[2];
    }
    function dbgNotchDecl($isCallback = false){
        if (!$this->dbgNotch) return '';
        $xDataProp = 'rDeclOutputData';
        $timePattern = 'y-m-d H:i:s';
        $notch = $this->dbgNotch('str', ' %date %notch %testPage', $timePattern);
        if ($isCallback) {
            $notch = array(
                $notch,
                $this->dbgNotch('str', '%headers', $timePattern),
            );
            $notch += explode("\r\n", $this->dbgNotch(false, '%request'));

            $declData = x($xDataProp);
            //$declData['>headers'] = getallheaders();
            //$declData['<headers'] = headers_list();
            //$declData['?headers'] = @$http_response_header;
            //d0($declData);
            if (isset($declData['notch'])) {
                $declData['notch'] = $notch;
                return $declData;
            } else { //case: prepend property `notch`
                $resDeclData = array('notch' => $notch);
                foreach ($declData as $prop => $val) {
                    $resDeclData[$prop] = $val;
                }
                return $resDeclData;
            }
        } else {
            x('outputASJson', array(
                'updAfterHeaders' => array(
                    'xPropData' => $xDataProp,
                    'xCall' => array($this, 'dbgNotchDecl'),
                    'xCallArgs' => array(true),
                    'xCallAddData' => false,
                    'xPropRes' => true
                )
            ));
            return $notch;
        }
    }

    function __get($name){
        if ($this->c) {
            if (property_exists($this->c, $name)) {
                return $this->c[$name];
            }
        }

        return null;
    }

    function __call($name, $arguments){
        switch ($name) {
            case 'dir': //+
            case 'jn': //+
            case 'url': //
            //case 'uri': //
            case 'name': //
            case 'rName': // [ps rName:api/decl
            case 'rvName': //
                $strToAdd = isset($arguments[0]) ? $arguments[0] : null;
                /*if (in_array($name, array('uri'))) {
                    $strToAdd = ltrim($strToAdd, '/');
                }*/
                $res = $this->extendStr($name, $strToAdd);
                //d('r.__call', $name, $strToAdd, $this->{$name}, $res);
                return $res;

            case 'uri': //
                $page = isset($arguments[0]) ? $arguments[0] : null;
                if ($page) $page = ltrim($page, '/');

                $query = isset($arguments[1]) ? $arguments[1] : null;
                $uri = $this->extendStr($name, $page);

                _needphp('url.class');
                $uri = url::q_ext($uri, $query);

                return $uri;

            case 'var': //
                $strToAdd = isset($arguments[0]) ? $arguments[0] : null;
                $varConvert = !isset($arguments[1]) || ($arguments[1] !== false);
                $newStr = $this->extendStr($name, $strToAdd, $varConvert ? '-' : '_');
                return $varConvert ? self::varName($newStr) : $newStr;

            default:
                //d($name, $this->c);

                if ($this->c) {
                    if (method_exists($this->c, $name)) {
                        return call_user_func_array(array($this->c, $name), $arguments);
                    }
                }

                $arg1 = isset($arguments[0]) ? $arguments[0] : null;
                $arg2 = isset($arguments[1]) ? $arguments[1] : '-';
                if ($arg1 && property_exists($this, $name)) {
                    return $this->extendStr($name, $arg1, $arg2);
                }
        }
        return null;
    }


	function req($subPath){
		$path = $this->dir($subPath);
		//if (is_file($path)) require_once ($path);
		req_try($path);
	}

	function inc($subPath, $res_type = INC_RES_AS_IS){
		$path = $this->dir($subPath);
		//if (is_file($path)) include ($path);
		return inc($path, $res_type);
	}

	function jd(){
		$args = func_get_args();

		$jn = $this->jn(ltrim(array_shift($args), '/'));
		//d($jn, $args);
		array_unshift($args, $jn);
		//d($args);
		return call_user_func_array('jd', $args);
	}

	function jdsn(){
		$args = func_get_args();
		$jn = $this->jn(array_shift($args));
		array_unshift($args, $jn);
		//d($args);
		return call_user_func_array('jdsn', $args);
	}

}

/*



-   -   -   -
function relUrl(){
    _needphp('gt/ref');

    dn(
        refPath,
        $_SERVER['HTTP_REFERER'],
        $this->dir,
        fileUrl($this->dir),
        $this->uri
    );
}
-   -   -   -

*/