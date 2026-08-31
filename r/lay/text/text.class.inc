<?

_lay::reg('text', array(
	'nc' => array(
		'base' => 'Tx'
	),
));

class lay_text extends lay {

	static function toHtml($text){
		return LayTextParser::applyHtml($text);
	}

	//L
	static function text2html($text){
		return LayTextParser::applyHtml($text);
	}
}


include_once 'LayTextParser.class.php';
include_once 'LayContentsMenu.class.php';