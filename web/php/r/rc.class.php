<?#4.4.0

_needphp('uv');
_needphp('url.class');
_needphp('json/jsonPrettyEncode');

//resource-component
class RC {

	function r(){ //get-parent
		static $r;

		switch (func_num_args()) {
			case 0:
				if (!$r) {
					$r = new oe();
				}
				break;
			case 1:
				$R = func_get_arg(0);
				$r = $R;
				break;
		}
		return $r;
	}

	function tpl($name, $ctx = array(), $subst = null){
		$r = $this->r();
		$path = $r->dir("tpl/$name.tpl.php");
		//d($path, is_file($path));
		return useTemplate($path, $ctx, $subst);
	}
	function dtpl(){
		$args = func_get_args();
		$tpl = call_user_func_array(array($this, 'tpl'), $args);
		return "<textarea>$tpl</textarea>";
	}


	//добавляет версионный параметр к имени страницы, относительно данного рессурса
	function qv($pagename, $qs = false, $incTestPage = true){
	    //[td $incTestPage и vType можно добавить через set()]


	    //0 if (func_num_args() == 2 && is_bool($qs)) $incTestPage = $qs; //[q tc]
            //case: сдвигаем третий аргумент, если указано только два и on bool
                //это для ? можно указать чуть быстрее ? [br]

        $self = $this->r();

        if ($pagename[0] === '.') {
            $ext = $pagename;
            $filename = prop($self, 'filename', $self->var);
            $pagename = $filename.$ext;
        }
        $q = array(); //добавка к url для версии
        if ($incTestPage && $self->isTestPage() || !1) {
            $q []= static::$testPagePrm;
        }
        $url = $self->uri($pagename, $q);

        $uv = uv($url); //url-версия

        $uri = url::q_ext($pagename, $q, $qs, "qv=$uv");

        //dx($uri, $uv, $url);

        return $uri;
    }
    //function qvc(){}
    //function qve(){}



    function declOutput($data, $cacheOn = true, $incTestPage = true){
        $self = $this->r(); //dx($self);

        //чё-то тут не правильно
        // как-то надо $declPath ~ __FILE__ , $data
        $declPath = $self->dir("decl.json.php");
	    if (!is_file($declPath)) $declPath = php('getCaller', 'path'); //u <-[q u] [:60]

        if (!'on') $self->dbgNotchDecl();

        if ($incTestPage && $self->isTestPage()) {
            $extra = etag::extra(static::$testPagePrm);
            if (is_null($cacheOn) || $cacheOn === true) {
                $cacheOn = $extra;
            } else {
                //[td addTo $extra]
            }
            //dx($cacheOn);
        }

        $this->jsonOutput($data, $declPath, $cacheOn);
    }

	function jsonOutput($data, $filePath = false, $cacheOn = null){

		$cacheState = self::cacheState($cacheOn, $filePath);
        if (!'debug') dx(
            $cacheState,
            headers_obj(etag::debug(true), $cacheState)->prepare_output(),
            date('H:i:s y/m/d'),
            notch()
        );

		_needphp('json/outputASJson');
        outputASJson($data, $cacheState);
    }

    static function cacheState($set = null, $filePath = false){
        $state = array(SITE_CACHE);
        if (!is_null($set)) {
            if ($set === false) {
                $state []= 'cache-off';
            } else {
                if ($filePath === true) $filePath = php('getCaller', 'path');
                $filePath = is_string($filePath) ? realpath($filePath) : false;

                if ($set === true) {
                    if ($filePath) {
                        $state []= array('etag_file' => $filePath);
                    }
                } else {
                    $set = (array) $set;
                    $ctx = isOrdinal($set) ? $set : (
                        isset($set['etag_ctx']) ? $set['etag_ctx'] : array(0 => $set)
                    );
                    if ($filePath) $ctx []= $filePath;
                    $state []= array('etag_ctx' => $ctx);
                }
            }
        }
        //dx($set, $filePath, $state);
        return $state;
    }

    function headers($headerType, $filePath = false, $cacheOpts = null, $moreHeaders = false){
        if (is_array($filePath)) { //case: сдвигаем аргументы влево на один
            $moreHeaders = $cacheOpts;
            $cacheOpts = $filePath;
            $filePath = false;
        }
        $headers = array();

        switch ($headerType) {
            case 'js': case 'css': case 'json': case 'html': case 'svg':
                if ($headerType == 'js') { _needphp('gjs'); }
                $headers []= $headerType;
                break;

            case 'tpl': case 'kotpl': case 'kotpls':
                if ($headerType == 'js') { _needphp('ghtml'); }
                $headers []= 'html';
                break;
        }

        if (!is_null($moreHeaders)) {
            $headers []= array('utf8', 'nosniff');
        }

	    $cacheState = self::cacheState($cacheOpts, $filePath); //dx($cacheState);

        $headers []= $cacheState;
        //if (isOrdinal($cacheState)) $headers = array_merge($headers, $cacheState); else $headers []= $cacheState;

        if ($moreHeaders) {
            $headers []= $moreHeaders;
            //if (isOrdinal($moreHeaders)) $headers = array_merge($headers, $moreHeaders); else $headers []= $moreHeaders;
        }

        //etag::debug(true); dx($headers, headers_obj($headers)->prepare_output());
        headers($headers);
    }

    function version($nonVersionValue = '--'){
        $ver = $nonVersionValue;

        _needphp('dirFind');
        if ($verFile = dirFindFirst('v', 'ext', $this->r()->dir, 0)) {
            $ver = basename($verFile, '.v');
        }

        return $ver;
    }

    static $testPageUri = '/test/';
    static $testPageUriExcept = '/test/code.php';
    static $testPagePrm = 'tp';
    function isTestPage($testUri = true, $testPrm = true, $exceptUri = true){ //[td $pattern = true]
        if ($testUri === true) $testUri = self::$testPageUri;
        if ($testPrm === true) $testPrm = self::$testPagePrm;
        if ($exceptUri === true) $exceptUri = self::$testPageUriExcept;
        _needphp('str', 'gt/ref');
        $_uri = $this->r()->uri($testUri); //testPageUriStart
        $_uriX = $this->r()->uri($exceptUri); //testPageExceptUri
        $_self = startsWith(URI, $_uri); //selfIsTest
        //if (endsWith(URI, $exceptUri))
        if (startsWith(URI, $_uriX)) $_self = false;
        $_ref = startsWith(refPath, $_uri); //refIsTest
        $_gt = gf_has($testPrm); //hasTestPrm
        //inc_inc('-d/p.u');
        //dx($_uri, array(URI, $_self), array(URI, $_ref));
        return $this->r()->isTestPage = $_self || $_ref || $_gt;
    }

    //r_collectTestData || static function
    function collectTestData($nums = true, $dirPath = true, $xAssign = true, $jsonEncode = true){
        _needphp('valArray', 'useTemplate');
        if ($dirPath === true) $dirPath = $this->r()->dir('test');
        else $dirPath = rtrim($dirPath, '\/');

        if (!is_array($nums)) {
            //?1&2&3&data=4
            $nums = array(
                'ctx' => hit( _hit('is_numeric', gi(0, 'key'), false), gt('ctx'), 1),
                'set' => hit( _hit('is_numeric', gi(1, 'key'), false), gt('ctx'), 'ctx'),
                'opt' => hit( _hit('is_numeric', gi(2, 'key'), false), gt('ctx'), 'ctx'),
                'data' => hit( gt('data'), 'ctx'),
            );
        }
        $nums = valArrayMap($nums);

        $data = array();
        foreach ($nums as $name => $num) {
            $path = "$dirPath/$name$num.js.inc";
            if (is_file($path)) {
                $data[$name] = useTemplate($path, array('r' => $this->r()));
            }
            //d($name, "$name$num.js.inc", is_file($path), $data[$name], $path);
        }
        if ($jsonEncode) {
            foreach ($data as $name => $item) {
                if (!is_string($item)) {
                    $data[$name] = jsonPrettyEncode($item);
                }
            }
        }
        if ($xAssign) {
            foreach ($data as $name => $item) {
                x("rtSet_$name", $item);
            }
        }
        //dx($data);
        return $data;
    }


}