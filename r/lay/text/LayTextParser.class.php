<?

class LayTextParser {

	public static function parseRules($text) {
		$res = [];


		$text = preg_replace(array(
			'/\r\n/',
			//'/\t+\n/'
		), "\n", $text);
		$lines = explode("\n\n", $text);

		$_opts = array();
		foreach ($lines as $line) {

			//dx($line);

			//case: закомментированный код

			//if (preg_match('/^\/\//', $line, $match)) {
			if (preg_match('/^\t/', $line, $match)) {
				continue;
			}

			$item = array();

			$hasSpec = preg_match('/^\:\:(.*)$/m', $line, $match);
			///$hasSpec = preg_match('^\:\:(.*?)::(.*)$', $line, $match);

			//d($hasSpec, $line, $match);
			if ($hasSpec) {
				$opts = trim($match[1]);
				$opts = preg_split("/\n/", $opts);

				if (0) {
					$opts = preg_split("/\:\:/", $opts);
					$opts0 = $opts; //dbg
					foreach ($opts as &$opt) {
						$opt = preg_split("/\n/", $opt);
					}
				}
				//dx($opts0, $opts);
				$_opts = array_merge($_opts, $opts);
				//$_opts = array_merge($_opts, (array)$opts);
				continue;
			}

			if (preg_match('/^\[(.*?)\s(.*)\]$/', $line, $match)) {

				switch($match[1]) {
					case 'img': {
						d('img', $match[2]);
					} break;
					case 'pics': {
						d('pics', $match[2]);
					} break;
				}
				d($match);
			}

			if ($_opts) {
				$item['opts'] = $_opts;
				$_opts = array(); //here: reset opts
			}

			if (!isset($item['type'])) {
				$item['type'] = 'p';
			}

			if (!isset($item['content'])) {
				$item['content'] = $line;
			}

			//d($item);
			$res []= $item;
		}

		//$parsedText = array_merge($parsedText, self::parseParagraphs($text));
		return $res;
	}

	public static function applyHtml($text) {
		$html = array();

		$rules = LayTextParser::parseRules($text);

		foreach ($rules as $rule) {
			switch ($rule['type']) {
				case 'p': {
					$res = lay_tpl('text', 'parser/p', $rule);
					$html []= $res;
				} break;
			}
		}

		return join(newline2, $html);
	}

	static function parseText($text){
		$res = preg_replace('/\n/', '<br />', $text);
		//dx($text);
		return $res;
	}

}

if (!1) {
	$text1 = <<<TEXT
Это абзац1.
Это абзац2.

А это еще один абзац.

	[pic https://example.com/image1.jpg]

:: Специальный раздел
	:: Специальный раздел opts

Это текст в специальном разделе.

	[pics https://example.com/image1.jpg https://example.com/image2.jpg]

Еще один абзац.
TEXT;

	$rules = LayTextParser::parseRules($text1);
	$html = LayTextParser::applyHtml($text1);

	dx($html, $rules);

}