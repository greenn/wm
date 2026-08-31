<?#3-2-17[h1q-20-20-1h-10-1]
_needphp('getCaller');

function _v($v, $path, $ext = false){
    #dx($v, $path, $ext);

    if (!is_file($path)) {
        print 'HTTP 444';
        exit;
    };

    if (!$ext) $ext = pathinfo($path, PATHINFO_EXTENSION);

    //set active context
    $restoreActive = false;
    $prevActive = v('active');
    if ($v) {
        if ($prevActive !== $v) {
            $restoreActive = true;
            v('active', $v);
        }
    }

    switch ($ext) {
        case 'css': case 'css.php': {
            headers('css', 'utf8', 'nosniff', array('etag_file' => __FILE__));
            header("X-Content-Type-Options: nosniff");
        } break;
        case 'js': case 'js.php': {
            headers('js', 'utf8', 'nosniff', array('etag_file' => __FILE__));
        } break;
    }
    #dx($path, realpath($path));

    //_vv($path);
    include $path;
    //_vv($path);


    //restore active context
    if ($restoreActive) {
        v('active', $prevActive);
    }
    exit;
}
function _vv($path, $ext = false){
    if (!$ext) $ext = pathinfo($path, PATHINFO_EXTENSION);
    switch ($ext) {
        case 'css': case 'css.php': {
            printf("/*%s:%s.%s:%s*/\r\r", vx('n'), vx('v'), vx('s'), basename($path));
        } break;
        case 'php': {
            printf("<!--%s:%s.%s:%s-->\r\r", vx('n'), vx('v'), vx('s'), basename($path));
        } break;
    }
}
function v_($rPath, $v = true){
    $vd = vd($v);
    $v = $vn = $vd['n'];
    $vv = $vd['v'];

    $tryPath = array();

    $s = DIRECTORY_SEPARATOR;
    $rInfo = pathinfo($rPath);
    $rPathName = sprintf("%s$s%s", $rInfo['dirname'], $rInfo['filename']);

    $rExt = $rInfo['extension'];
    $tryExt = array($rExt);
    if ($rExt !== 'php')
        $tryExt []= $rExt.'.php';


    //local version: path.v.ext
    $trySubExt = array($vn, $vv);
    foreach ($tryExt as $ext) foreach ($trySubExt as $subExt) {
        $p = ROOTs.sprintf("%s.%s.%s", $rPathName, $subExt, $ext);
        $tryPath[$p] = $vn;
    }


    //saved version: r/v/path.ext
    $dir = WEB.'/v';
    $tryVersion = array($vn);

    if ($vd['extend']) $tryVersion []= $vd['extend'];
    if (v('useDowngrade')) while (--$vn > 0) $tryVersion []= $vn;
    if (v('useReserve')) $tryVersion []= v('reserve');
    if ($v !== v('default')) $tryVersion []= v('default');


    #d($tryVersion);
    foreach ($tryVersion as $verN) {
        foreach ($tryExt as $ext) {
            $ver = vd($verN, 'v');
            $p = "$dir/$ver/$rPathName.$ext";
            //$p = sprintf("%s$s%s$s%s.%s", $dir, $ver, $rPathName, $ext);
            #d($verN, $ver, $p, !isset($tryPath[$p]));
            if (!isset($tryPath[$p])) {
                $tryPath[$p] = $verN;
                //возможно имеет смысл ставить: $vn
                    //для useDowngrade
                    //для useReserve
                    //для extend
                    //для default
            }
        }
    }

    //self version: path.ext
    foreach ($tryExt as $ext) {
        $p = ROOTs.sprintf('%s.%s', $rPathName, $ext);
        $tryPath[$p] = $v;
    }

    #foreach ($tryPath as $path => $verN) $tryPath[$path] = array(realpath($path), $verN); dx($tryPath);
    #dx($tryPath);
    $selfPath = getCaller('path');
    foreach ($tryPath as $path => $verN) {
        $path = realpath($path);
        if ($path) {
            if ($path !== $selfPath) { //prevent selfIncluding
                _v($verN, $path, $rExt);
            }
        }
    }

    print 'HTTP 444';
    //print ' (No Response)';
    exit;
}

function v($prop = null, $value = null){

    static $ctx;
    static $active;

    static $default = '00';
    static $reserve = '00';
    static $config = array();


    static $useDowngrade = false;
    static $useReserve = true;

    $var = &${$prop};

    switch (func_num_args()) {
        case 0;
            return is_array($ctx) ? $ctx['v'] : $default;

        case 1;
            return $var;

        case 2:
            $var = $value;

            if (in_array($prop, array('active', 'default', 'config'))) {
                $ctx = vd();
            }
            break;
    }
}

function vd($vn = true, $subName = null){
    if ($vn === true) {
        $vn = v('active');
        if (!$vn) $vn = v('default');
    }
    $config = v('config');
    $data = isset($config[$vn]) ? $config[$vn] : $vn;
    if (!is_array($data)) $data = array('v' => $data);
    if (!isset($data['s'])) $data['s'] = 'a';
    if (!isset($data['n'])) $data['n'] = $vn;

    if (!isset($data['extend'])) $data['extend'] = false;

    return !$subName ? $data : (isset($data[$subName]) ? $data[$subName] : null);
}

function vx($name){
    $ctx = v('ctx');
    return ( is_array($ctx) && isset($ctx[$name]) ) ? $ctx[$name] : null;
}
function v_is($subName, $isValue){
    return (string)vx($subName) === (string)$isValue;
}
function v_has($versionNumber){
    $versionStack = v('config');
    return isset($versionStack[$versionNumber]);
}






