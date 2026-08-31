<?#2.2.1
_needphp(
	'transliterate',
	'fq/str/str2val'
);

class strDataParser {

	//function __construct($text) {}

	static function parse($struct){
		$list = array();

		$lines = preg_split("/\r\n|\n|\r/", $struct);

		foreach ($lines as $line) {
			$item = static::extract($line);
			$list []= $item;
		}

		return $list;
	}



	static $sid = 0;

	static $line = ''; //temp
	static $ctx = array(); //temp
	static $item = array(); //temp
	static function _reset($line, $ctx = array()){
		static::$line = $line;
		static::$ctx = $ctx;
		static::$item = array();
		static::_ctx('line-src', $line);
		static::_ctx('sid', static::$sid++);
	}

	static function _ctx($name, $val){
		static::$ctx[$name] = $val;
	}
	static function _ctxHas($name){
		return array_key_exists($name, static::$ctx);
	}
	static function _ctxVal($name, $otherwise = null){
		return static::_ctxHas($name) ? static::$ctx[$name] : $otherwise;
	}

	static function extract($line){
		static::_reset($line);

		static::_extractBefore();
		static::_extractOptsData();
		static::_extractAfter();

		static::_ctx('line-res', static::$line);
		static::_ctx('line-res-trans', transliterate(static::$line));

		return static::$ctx;
	}

	static function _extractBefore(){
		static::_extractBeforeTabs();
		static::_extractBeforeSpace();
		static::_extractBeforeSkip();
	}

	static function _extractBeforeSpace(){
		preg_match("/^\s+/u", static::$line, $matches);
		static::_ctx('before-space', $matches ? strlen($matches[0]) : 0);
		static::$line = ltrim(static::$line, " ");
	}
	static function _extractBeforeTabs(){
		preg_match("/^\t+/u", static::$line, $matches);
		static::_ctx('before-tab', $matches ? strlen($matches[0]) : 0);
		static::$line = ltrim(static::$line, "\s");
	}

	static $beforeSkipSign = '//';
	static function _extractBeforeSkip(){
		$pattern = "~^".preg_quote(static::$beforeSkipSign)."~u";
		//dx($pattern, preg_match($pattern, static::$line));
		if (preg_match($pattern, static::$line)) {
			static::_ctx('skip', true);
			static::$line = preg_replace($pattern, '', static::$line);
		}
	}

	static function _extractAfter(){
		static::_extractAfterTabs();
		static::_extractAfterSpace();
	}

	/*
	$string = "example-substring";
	$pattern = '/-substring$/';

	if (preg_match($pattern, $string)) {
	    $modifiedString = preg_replace($pattern, '', $string);
	    echo "Найдена и отсечена суб-строка: $modifiedString";
	} else {
	    echo "Суб-строка не найдена.";
	}
	*/
	static function _extractAfterSpace(){
		preg_match("/\s+$/u", static::$line, $matches);
		static::_ctx('after-space', $matches ? strlen($matches[0]) : 0);
		static::$line = rtrim(static::$line, " ");
	}
	static function _extractAfterTabs(){
		preg_match("/\t+$/u", static::$line, $matches);
		static::_ctx('after-tab', $matches ? strlen($matches[0]) : 0);
		static::$line = rtrim(static::$line, "\s");
	}

	//[eg] Рассылки \ name=trg-par link=notify
	static $optStartSign = '\\';
	static $optItemSep = ' ';
	static $optValSep = '=';
	static function _extractOptsData(){
		$optsData = '';
		if (strpos(static::$line, static::$optStartSign) !== false) {
			$optsData = strstr(static::$line, static::$optStartSign);
			$optsData = substr_replace($optsData, "", 0, strlen(static::$optStartSign));
			$optsData = trim($optsData);
			static::$line = strstr(static::$line, static::$optStartSign, true);
		}
		static::_ctx('line-opts', $optsData);

		if ($optsData) {
			$opts = static::extractOpts($optsData);
			static::_ctx('opts', $opts);
		}

	}

	static function extractOpts($strData){
		$opts = array();
		$optsData = explode(static::$optItemSep, $strData);
		foreach ($optsData as $index => $opt) {
			if (strpos($opt, static::$optValSep) !== false) {
				$value = strstr($opt, static::$optValSep);
				$value = substr_replace($value, "", 0, strlen(static::$optValSep));
				$value = trim($value);
				$value = str2val($value);

				$prop = strstr($opt, static::$optValSep, true);
			} else {
				$prop = $opt;
				$value = true;
			}
			$opts[$prop] = $value;
		}
		return $opts;
	}


}