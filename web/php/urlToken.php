<? //7-23
_needphp('parseUrl');

function urlToken($url = true, $dirRelative = false){
    if ($url === true)
        $url = URI;

	if ($dirRelative) {
		if ($dirRelative === true) {
			_needphp('dirUrl', 'getCaller');
			$dirRelative = dirUrl_(getCaller('dir'));
		}
		$url = php('strLess', ltrim($url, '/'), ltrim($dirRelative, '/'));
	}


	return new _urlToken($url);
}

//add relative()->get(n)


class _urlToken {

    function __construct($url = true) { //d('construct _urlToken');
		if ($url === true)
			$url = URI;

		$this->setUrl($url);
	}

	var $urlInfo = array();
	var $domain = '';
	var $uri = '';
    //var $urlInfoExtraParsers = array('getArguments');
    var $urlInfoExtraParsers = false;
	function setUrl($givenUrl){
		if (is_string($givenUrl))
			$this->url = $givenUrl;
		$this->urlInfo = parseUrl($this->url, $this->urlInfoExtraParsers);
		$this->domain = $this->urlInfo['domain'];
		$this->buildTokens();
		$this->buildArguments();
		return $this;
	}

	var $tokens = array();
	var $tokensLength = 0;
    //var $urlInfoExtraParsers = true;
	private function buildTokens(){
		$this->uri = $this->urlInfo[PHP_URL_PATH];
        $trimedUri = trim($this->uri, '/');
        $tokens = $trimedUri ? explode('/', $trimedUri) : array();
		$this->tokens = $tokens;
		$this->tokensLength = count($tokens);
	}
	function n($num, $otherwise = null){
		$index = $num - 1;
		return isset($this->tokens[$index]) ? $this->tokens[$index] : $otherwise;
	}
	function get($name){ /*, $options | = true, > join after */
		$token = false;
		if (is_numeric($name))
			$token = $this->n($name);
		elseif (is_string($name)) switch ($name) {
			case 'last';
				$token = $this->n($this->tokensLength);
				break;
		}

		return $token;
	}
    //установка максимального кол-ва токенов
    //если их большо, то происходит объединение
    function max($nMax) {
        if ($nMax < $this->tokensLength) {
            $restTokens = array_splice($this->tokens, $nMax - 1);
            $lastToken = join('/', $restTokens);
            array_push($this->tokens, $lastToken);
            $this->tokensLength = $nMax;
        }
        return $this;
    }


    var $query = '';
    var $arguments = array();
    var $otpions = array();
    var $otpionsOrder = array();
    var $otpionsQuantity = 0;
	private function buildArguments(){
        $this->query = $this->urlInfo[PHP_URL_QUERY];
        list($this->arguments, $this->otpions) = $this->optParseQuery($this->urlInfo[PHP_URL_QUERY]);
        $this->otpionsQuantity = count($this->otpions);

        $optionsNumber = 1;
        foreach ($this->otpions as $name => $opt) {
            $opt->pos = $optionsNumber++;
            $this->otpionsOrder[$opt->pos] = $name;
        }
	}
    var $originalQuery;
    function optParseQuery($stringQuery){

        # re | +

        $this->originalQuery = $stringQuery;
        //return parseQuery($stringQuery, 2);
        $args = array(); $opts = array();
        //$m_qRega = '/([^&?]+\?(?:[\D\d](?!\&\&))+\&?\&?.)|(?:([^&]*)\&?)?/'; # https://regex101.com/r/ZjtHe2/3
        $m_qRega = '/([^&?]*\?(?:[\D\d](?!\&\&))+.)\&?\&?|(?:([^&]*)\&?)?/'; # https://regex101.com/r/ZjtHe2/4

        preg_match_all($m_qRega, $stringQuery, $queryParts, PREG_SET_ORDER);
        array_pop($queryParts);

        foreach ($queryParts as $index => $queryRes) {
            $isSubQuery = count($queryRes) == 2;
            # $isSubQuery - строка со знаком ?, останавливается после &&
            $string = $isSubQuery ? $queryRes[1] : $queryRes[2];


            $opt = new opt($string, !$isSubQuery);
            $opt->index = $index;
            $opt->isSubQuery = $isSubQuery;
            $opt->isUrl = preg_match('/^(\w+\:)?\/\/[^\/\:]/', $opt->value);

            $optName = $opt->name;
            if (isset($opts[$optName])) {
                $prevOpt = $opts[$optName];
                $opt->addDuplicate($prevOpt);
            }

            $opts[$optName] = $opt;
            $args[] = $opt;
        }

        //dx($queryParts, $args, $opts);
        return array($args, $opts);
    }
    function args(){
        return $this->arguments;
    }
    function arg($argIndex = 0, $reponsePair = false){
        $argument = null;
        if (isset($this->arguments[$argIndex])) {
            $arg = $this->arguments[$argIndex];
            $argument = $reponsePair ? $arg : (isset($arg[1]) ? $arg[1] : $arg[0]);
        }
        return $argument;
    }

    function opts(){
        return $this->otpions;
    }
    function hasOpts(){
        return $this->otpionsQuantity > 0;
    }
    //aka hasOptName
    function hasOpt($name){
        return isset($this->otpions[$name]);
    }
    function optName($pos){
        $optionName = null;
        if ($this->hasOptPos($pos)) {
            $optionName = $this->otpionsOrder[$pos];
        }
        return $optionName;
    }
    function hasOptPos($pos){
        return isset($this->otpionsOrder[$pos]);
    }
    function optPos($optionName){
        return array_search($optionName, $this->otpionsOrder);
    }
    function optVal($id = ''){
        return $this->optGet($id)->value;
    }
    # Получение опции по имени
    function opt($optionName = ''){
        $option = null;
        if ($this->hasOpt($optionName)) {
            $option = $this->otpions[$optionName];
        }
        return $option ? $option : new optUndefined();
    }
    function optN($pos = null){
        if (func_num_args() === 0)
            return $this->otpionsQuantity;

        return $this->opt($this->optName($pos));
    }
    function optGet($id){
        return is_integer($id) ? $this->optN($id) : $this->opt($id);
    }

    function optLookNames(){
        for ($i = 0, $l = func_num_args(); $i < $l; $i++) {
            $name = func_get_arg($i);
            if ($this->hasOpt($name))
                return $this->opt($name);
        }
        return false;
    }

    function isOptEqual($id, $compareValue){
        return $this->optGet($id)->value === $compareValue;
    }

    function optFindUrl($resNum = 1){
        foreach ($this->opts() as $opt) {
            if ($opt->isUrl && (--$resNum < 1))
                return $opt;
        }
        return new optUndefined();
    }
    function optFindBoolean($resNum = 1){
        foreach ($this->opts() as $opt) {
            if ($opt->isBoolean && (--$resNum < 1))
                return $opt;
        }
        return new optUndefined();
    }

}

//3-0
class opt {

    var $index;
    function __construct($query, $isQuery = true){
        $this->setQuery($query, $isQuery);
    }

    var $name;
    var $rawValue;
    var $value;
    var $hasEqualSign;
    var $keyIsFalse;
    var $keyIsTrue;
    var $keyIsBoolean;
    var $valIsFalse;
    var $valIsTrue;
    var $valIsBoolean;
    var $isTrue;
    var $isFalse;
    var $isNull;
    var $isNumeric;

    function setQuery($string, $isQuery = true){

        $val = $isQuery ? explode('=', $string, 2) : array($string);
        $this->hasEqualSign = isset($val[1]);
        $this->name = $val[0];

        $this->keyIsFalse = $this->_isFalse($this->name);
        $this->keyIsTrue = $this->_isTrue($this->name);
        $this->keyIsBoolean = $this->keyIsFalse || $this->keyIsTrue;

        $autoValue = $this->keyIsFalse ? $this->optTrueValues[0] : $val[0];
            #чё-за $autoValue .. -то если указано нотолько имя аргумента
        $this->rawValue = $this->hasEqualSign ? $val[1] : $autoValue;
        $this->value = urldecode($this->rawValue);

        $this->valIsFalse = $this->_isFalse($this->value);
        $this->valIsTrue = $this->_isTrue($this->value);
        $this->valIsBoolean = $this->valIsFalse || $this->valIsTrue;

        $this->isBoolean = $this->keyIsBoolean || $this->valIsBoolean;

        if ($this->keyIsBoolean) {
            if ($this->valIsBoolean) {
                $this->isTrue = $this->keyIsTrue ? $this->valIsTrue : $this->valIsFalse;
                $this->isFalse = !$this->isTrue;
                $this->value = $this->isTrue;
            } else {
                $this->setQuery(join('=', array_reverse($val)));
            }
        } elseif ($this->valIsBoolean) {
            $this->isTrue = $this->valIsTrue;
            $this->isFalse = $this->valIsFalse;
            $this->value = $this->isTrue;
        } else {
            $this->isTrue = true;
            $this->isFalse = false;
        }

        $this->isNumeric = is_numeric($this->rawValue);
        $this->isNull = $this->rawValue === 'null';
    }

    var $optTrueValues = array('', 'true', '1', 'on', 'yes', '+');
    var $optFalseValues = array('false', '0', 'no', 'off', '-');
    function _isFalse($string){
        return in_array($string, $this->optFalseValues);
    }
    function _isTrue($string){
        return in_array($string, $this->optTrueValues);
    }

    var $duplicates = array();
    function addDuplicate($opt){
        if (count($opt->duplicates)) {
            $this->duplicates = array_merge($this->duplicates, $opt->duplicates);
        }
        $this->duplicates[] = $opt;
    }

    function __toString(){
        return (string) $this->rawValue;
    }
}

_needphp('cache');

//02-17
class optUndefined {
    var $isUndefined = true;
    function __construct(){
        $this->isUndefined = cacheCountInc('optUndefined'); //todo cacheCountInc
    }
    function __get($name){
        return null;
    }
    function __call($method, $args){
        return null;
    }
}


//opt как инстанце
//opt ~ optVal
## opt(1)->isTrue?
## opt(1)->isBoolean
## opt(1)->realPos
## opt(1)->pos
## opt(1)->isCompound ~ has &


/*

$opt1 = $this->isOptWithoutValue(1) ? $url->optQuery(1, true) с-по


*/

/* 2017-04-08
    ->startWith('page/subpage/)
*/