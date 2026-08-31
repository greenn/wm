<?#4.9.1
//что-то очень старое типо jdb

_needphp('json/jsonError'); //jsonLastErrorMsg

//Получение кешируемого объекта JSON-контекста
function j($jConf = null, $rebuild = false){

    $jPath = J::checkPath($jConf);

    if (empty($jPath)) { return null; }


    $path = $jPath[0];
    $cache = j_($path);

    if (!$cache || $rebuild) {
        $jSet = j_set($jConf);
        $J = new J($jPath, $jSet);

        j_($path, $J); //кешируем объект
    } else {
        $J = $cache;
    }

    return $J;
};

//cache object for JSON-контекст
function j_($cName = null, $cValue = null){
    static $cache = array();
        $r = null;

    $argN = func_num_args();
    switch ($argN){
        case 0: $r = $cache; break;
        case 1: if (isset($cache[$cName])) $r = $cache[$cName]; break;
        case 2: $r = $cache[$cName] = $cValue; break;
    }
    return $r;
}


//Извлечение данных по имени
//jd('logo', 'image', 'url');
function jd($jName){

    $J = j($jName); //dx($J);
    if (!$J) return null;

    $dataChain = func_get_args();
    array_shift($dataChain);

    //return call_user_func_array(array($J, 'dataChainSlice'), $dataChain);
    return $J->dataSlice($dataChain);

}


//сохранение данных по пути
function jr($jDataPath, $value){

    if (!is_array($jDataPath)) {
        $jDataPath = array($jDataPath);
    }
    $jName = array_shift($jDataPath);
    //d('jr:', $jName, $jDataPath);

    $jPath = J::checkPath($jName);

    if (empty($jPath)) {
        J::create($jName);
    }

    $J = j($jName);
    return $J->save($value, $jDataPath);
}

//Удаление данных по пути
function jru($jDataPath){
    if (!is_array($jDataPath)) {
        $jDataPath = array($jDataPath);
    }
    $jName = array_shift($jDataPath);

    $J = j($jName);
    if ($J) {
        $J->delete($jDataPath);
    }
}

//jdp

//получение типового имени для j по пути файла
function jn($jType, $path = '', $pathOpt = false){
    if (empty($path)) {
        $path = php('getCaller', 'path');
    }

    _needphp('strLess');
    $jName = "path::$path";
    switch ($jType) {
        case 'r': case 'rc':
            $jName = "$jType::".
                str_replace('\\', '/',
                    pathLess(
                        dirname($path), ROOT.'/r/'
                    )
                )
            ;
            break;
        case 'y': case 'yc':
            $jName = "$jType::".
                str_replace('\\', '/',
                    pathLess(
                        dirname($path), ROOT.'/y/'
                    )
                )
            ;
        break;
    }


    return $jName;
}


//JsonDataStack
//получение стека данных, по заданными срезам
/*
extract(jds(array(
    'img' => array('r::logo', 'logo', 'url-image')
)));
*/
function jds(){
    $stack = array();
    $args = func_get_args();
    foreach ($args as $arg) {
        foreach ($arg as $sName => $jdPath) {
            //d($jdPath);
            $stack[$sName] = call_user_func_array('jd', $jdPath);
        }
    }

    return $stack;
}

//JsonDataStack-byName
//получение стека данных, по заданными срезам внутри одного JSON'а
/*
jdsn('r::logo',
    'text',
    array('email' => array('email', 'value')),
    array('images' => 'logo')
)
*/
function jdsn($jName){

    _needphp('isAssoc');

    $stack = array();

    $args = func_get_args();
    array_shift($args);
    $J = j($jName);

    if ($J) {
	    if (empty($args)) {
		    $stack = $J->data();
	    } else foreach ($args as $arg) {

		    if (is_array($arg)) {
			    //d($arg, isAssoc($arg));
			    if (isAssoc($arg)) foreach ($arg as $sName => $jdPath) {
				    if ($jdPath === false) continue;
				    if ($jdPath === true) $jdPath = $sName;
				    if (!is_array($jdPath)) $jdPath = array($jdPath);
				    //d($sName, $jdPath);
				    $stack[$sName] = $J->dataSlice($jdPath);
			    } else foreach ($arg as $dName) {
				    $stack[$dName] = $J->dataSlice($dName);
			    }
		    } else {
			    $dName = $arg;
			    $stack[$dName] = $J->dataChainSlice($dName);
		    }

	    }
    }


    return $stack;

}



function j_set(){
    static $cache = array();
    switch (func_num_args()) {
        case 0;
            return $cache;

        case 1:
            $jName = func_get_arg(0);
            return isset($cache[$jName]) ? $cache[$jName] : null;

        case 2:
            $jName = func_get_arg(0);
            $jConf = func_get_arg(1);
            $cache[$jName] = $jConf;
            return $jConf;
    }

}

_needphp('g');

class J {
    static function checkPath($pathConf, $returnWithType = true) {
        $path = self::getPath($pathConf);

        if ($returnWithType) {
            return $path ? array($path, self::getPathType($path)) : array();
        } else {
            return $path ? $path : false;
        }
    }
    static $pathVariantSplitter = '::';
    static $pathVariants = array(
        'y' => array(
            '%s/y/%s/d.json.php',
            '%s/y/%s/d.json',
            '%s/y/%s',
        ),
        'yc' => array(
            '%s/y/%s/c.json.php',
            '%s/y/%s/c.json',
            '%s/y/%s',
        ),
        'r' => array(
            '%s/r/%s/data.json.php',
            '%s/r/%s/d.json.php',
            '%s/r/%s/data.json',
            '%s/r/%s/d.json',
            '%s/r/%s',
        ),
        'rc' => array( //resource-config
            '%s/r/%s/conf.json.php',
            '%s/r/%s/c.json.php',
            '%s/r/%s/conf.json',
            '%s/r/%s/c.json',
            '%s/r/%s',
        ),
        'page' => array( //pid
            '%s/web/data/pages/%s.json',
            '%s/web/data/pages/%s.json.php',
        ),
        'uri' => array(
            '%2$s.php',
            '%2$s',
        ),
        'path' => array(
            '%2$s.json.php', # +
            '%2$s.json',
            '%2$s.php',
            '%2$s', # +
	        //bad ?
	        '%s%s.json.php', # +
	        '%s%s.json',
	        '%s%s.php',
	        '%s%s',
	        //bad ?
	        '%s/%s.json.php', # +
	        '%s/%s.json',
	        '%s/%s.php',
	        '%s/%s',

        ),
        'root' => array(
            '%s/%s/data.json.php',
            '%s/%s/c.json.php',
            '%s/%s/data.json',
            '%s/%s/c.json',
	        '%s/%s.json.php', #+
	        '%s/%s.json',
            '%s/%s',
	        '%s/%s.json.php', # +
	        '%s/%s.json',
        ),

    );
    static function getPath($pathConf) {

        $pathStr = (string)$pathConf;
        if (is_file($pathStr)) return $pathStr;


        $pathType = 'path';
        $pathVal = $pathConf;

        $pathData = explode(self::$pathVariantSplitter, $pathStr);
        if (count($pathData) === 2) {
            list($pathType, $pathVal) = $pathData;
        }

        if ($pathType === 'uri') {
            _needphp('json/l/jc');
            $uriConf = jd(jpPagelist, $pathVal); //dn(jpPagelist, $uriConf, $pathVal);
            $jsonPath = is_array($uriConf) && isset($uriConf['page']) ? $uriConf['page'] : $uriConf;

            $pathVal = is_string($jsonPath) ? sprintf($jsonPath, WEB.'/data/pages') : false;
        }

        if ($pathType === 'pid') {
			_needphp('json/l/jc');
            $pageId = jd(jpPidlist, $pathVal);
            if (!$pageId) $pageId = $pathVal;
            //d($pageId, $pathVal);
            $pathType = 'page';
            $pathVal = $pageId;
        }


        if (is_string($pathVal) && isset(self::$pathVariants[$pathType])) {
            $pathStack = self::$pathVariants[$pathType];
            foreach ($pathStack as $tryPath) {
                $path = sprintf($tryPath, ROOT, $pathVal);
                if (is_file($path)) return $path;
            }
        }

        return false;
    }
    static function getPathType($path){
        $type = 'get';
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext == 'php' || $ext == 'inc') {
            $type = 'inc';
        }
        return $type;
    }

    var $path;
    var $pathType;
    function setPath($pathConf){
        if (is_array($pathConf)) { /*aka preparedData*/
            list($this->path, $this->pathType) = $pathConf;
        } else {
            list($this->path, $this->pathType) = self::checkPath($pathConf);
        }
    }

    var $set = array();
    function __construct($pathConf, $options = null){
        //d('jBuild:', $pathConf);
        $this->set = (array)$options;
        $this->setPath($pathConf);

        //chaining
        return $this;
    }

    private $data = null;
    function data(){
        if (!$this->hasLoaded) {
            $this->load();
        }
        //d($this->hasLoaded, $this->data, $this);
        return $this->data;
    }

    var $content = null;
    private function getContent(){
        $this->content = file_get_contents($this->path);
    }
    private function incContent(){
	    gIncr('preventHeaders');
        ob_start();
        $data = include $this->path;
        $str = ob_get_clean();
	    gDecr('preventHeaders');
        //d($this->path, $str, $data);
        $this->content = $str ? $str : $data;
    }
    var $error = false;
    private function parseContent(){
        //d($this->content);
        if (is_string($this->content)) {
            $this->data = json_decode($this->content, true);
            if (!$this->data) {
                $this->error = jsonLastErrorMsg();
            }
        } else if (!is_null($this->content)) {
            $this->data = $this->content;
        }
    }

    var $hasLoaded = false;
    function load() {
        //d($this->path, $this->pathType, is_file($this->path));
        if (!is_file($this->path)) return;

        switch ($this->pathType) {
            case 'inc': $this->incContent(); break;
            case 'get': $this->getContent(); break;
        }

        $this->parseContent();
        $this->hasLoaded = true;
    }

    function dataChainSlice(){
        $args = func_get_args();
        return $this->dataSlice($args);
    }
    function dataSlice($args){
        $data = $this->data(); //d($data, $args);

        if (!empty($args)) foreach ($args as $prop) {
            if (is_array($data) && isset($data[$prop])) {
                $data = $data[$prop];
            } else {
                return null;
            }
        }

        return $data;
    }


    static function create($jPath){
        $path = $jPath;
        //if (is_file($path)) return;

        //d('j:файл создан', $path, $jPath);
        $dirPath = dirname($path);
        !is_dir($dirPath) && mkdir($dirPath, 0644, true);
        touch($path);
    }

    private function remove(){
        //d('j:файл удалён', $this->path);
        unlink($this->path);
    }

    function delete($dataPath){
        //d($dataPath);

        if (!is_array($dataPath)) {
            $dataPath = array($dataPath);
        }

        if (empty($dataPath)) {
            return $this->remove();
        }

        $data = $this->data();
        $dataCut = &$data;
        $delPropIndex = count($dataPath) - 1;

        if (is_array($dataPath)) foreach ($dataPath as $index => $prop) {
            if (!isset($dataCut[$prop])) return false;
            if ($index === $delPropIndex) {
                //d('del', $prop, $dataPath, $dataCut[$prop]);
                unset($dataCut[$prop]);
            } else {
                $dataCut = &$dataCut[$prop];
            }
        }

        $dataJson = self::encode($data);

        //return file_save($this->path, $dataJson);
        $f = fopen($this->path, "wb");
        $status = fwrite($f, $dataJson);
        fclose($f);
        //dx($this->path, $dataJson, $status);

        $this->data = $data;
        return $status;
    }
    function save($dataValue, $dataPath = false) {


        $dataNew = $this->data();
        $dataCut = &$dataNew;
        if (is_array($dataPath)) foreach ($dataPath as $prop) {
            if (!isset($dataCut[$prop])) {
                if (!is_array($dataCut)) {
                    $dataCut = array();
                }
                $dataCut[$prop] = array();
            }
            $dataCut = &$dataCut[$prop];
        }
        $dataCut = $dataValue;
        //dx($dataPath, $dataNew);


        /*$dataNew = array();
        $dataCut = &$dataNew;
        if (is_array($dataPath)) foreach ($dataPath as $prop) {
            $dataCut[$prop] = array();
            $dataCut = &$dataCut[$prop];
        }
        $dataCut = $dataValue;
        d($dataPath, $dataNew);*/

        //$this->data = is_array($this->data) ? array_replace_recursive($this->data, $dataNew) : $dataNew;
        $this->data = $dataNew;

        $dataJson = self::encode($this->data);

        //utf8_decode()
        //$dataJson = html_entity_decode($dataJson, ENT_NOQUOTES, 'UTF-8');



        //return file_save($this->path, $dataJson);
        $f = fopen($this->path, "wb");
        $status = fwrite($f, $dataJson);
        fclose($f);
        //dx($this->path, $dataJson, $status);
        return $status;
    }

    public static function encode($data){
        if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
            return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode($data);
        }
    }
}


/* * * * * to do * * * * */

/*
jdsn('/r/logo/data.json.php',
    'text',
    array('path' => ),
    array('images' => 'logo')
)
*/
function jdsp($jPath) {

}

/*
jc('logo', 'logo', 'url-image')->set('/new/url/png');
*/
/*J_chainer*/
class JC {
    var $J;
    function __construct($J) {
        $this->J = $J;
    }

    function set(){}


    function save(){}
}

function jc($jName){
    //$jIdn;
    //$jName;
    //$jPath;
    return new JC( j($jName) );
}

function jdw(){}

