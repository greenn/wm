<?
_needphp('transliterate');

class LayContentsMenu {

	var $stack = array();
	var $curIndex = 0;

	function __toString(){
		return $this->ul();
	}

	function __construct($text){
		$this->parse($text);

	}


	function makeUri($data){
		$anchor = transliterate($data['text']);
		$anchor = strtolower($anchor);
		$anchor = str_replace(' ', '-', $anchor);
		$uri = URI.'#'.$anchor;
		return $uri;
	}

	function ul(){
		$html = array();
		$html []= '<ul>';
		foreach ($this->items as $item) {
			$html []= '<li>';
			$as = attr::asd(array(
				'href' => static::makeUri($item),
			));
			$html []= "<a $as>";
			$html []= $item['text'];
			$html []= '</a>';
			$html []= '</li>';
		}
		$html []= '</ul>';

		return join(newline, $html);
	}


	function addItem($text)	 {

	}


	function parse($text) {
		$lines = explode("\n", $text);
		foreach ($lines as $line) {
			//d($line);
		}

	}

	static function convertToLink($string){
		$link = transliterate($string);
		$link = strtolower($link);
		$link = str_replace(' ', '-', $link);
		return $link;
	}

}

if (!1) {
	$text1 = <<<TEXT
Контактная информация
Ситуации, требующие своевременной транспортировки
Риски мошенничества
Преимущества обращения в ритуальные агентства
Необходимость быстрой транспортировки
Санитарные нормы и традиции
Процедура перевозки и услуги в морге
Констатация смерти
Бесплатная транспортировка
TEXT;

	$CMenu = new LayContentsMenu($text1);
	dx($CMenu, $text1);

}