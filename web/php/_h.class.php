<?#0.2.7
/*
	[tg] iq/test/php/hc.php
*/
_needphp(
	'x/x_'
);

//x_('ctrl', 5); //dbg



function _h($tag, $content = '', $attr_value = false, $attr_name = 'style'){
	return _h::auto_tag($tag, $content, $attr_value, $attr_name);
}

class _h {
	static function tag($tag, $attrs = array(), $content){
		$a_ = array();
		foreach ($attrs as $attr => $value) {
			$value_method = "attr_$attr";
			//if (is_callable("_h::attr_$attr")) { //zc - рекурсит на __callStatic
			if (method_exists("_h", $value_method)) { //method_exists(__CLASS__, $value_method)
				$value = call_user_func("_h::$value_method", $value);
			}
			if ($value !== false) {
				$_a = is_null($value) ? $attr : "$attr=\"$value\"";
				$a_ []= $_a;	
			}

		}
		$_a_ = join(' ', $a_);
		if ($_a_) $_a_ = ' '.$_a_;

		$_content = is_array($content) ? join(newline, $content) : $content;

		return "<{$tag}{$_a_}>$_content</$tag>";
	}
	//static function attr_style(){ dx(func_get_args()); }

	/* [lde]
	static function p($content, $attr_value = false, $attr_name = 'style'){
		$attrs = array();
		if ($attr_name === true) $attrs = $attr_value;
		else $attrs[$attr_name] = $attr_value;
		return _h::tag('p', $attrs, $content);

		//$a_style = $styles ? "style=\"$styles\"" : '';
		//return "<p $a_style>$content</p>";
	}
	*/

	//|auto_tag|tag_constructor|
	static function auto_tag($tag, $content = '', $attr_value = false, $attr_name = 'style'){
		$attrs = array();
		if ($attr_name === true) $attrs = $attr_value;
		else $attrs[$attr_name] = $attr_value;
		$tagChunks = explode(' ', $tag);
		if ($tagChunks > 1) {
			$tag = array_shift($tagChunks);
			$add_attrs = join(' ', $tagChunks);
			$attrs[$add_attrs] = null;
		}

		return _h::tag($tag, $attrs, $content);

		//$a_style = $styles ? "style=\"$styles\"" : '';
		//return "<p $a_style>$content</p>";
	}

	//static $tagsList = array('h', 'b');
	static function __callStatic($method, $args_) {
		//d($method, $args_); if (x::decr('ctrl') <= 0) exit; //dbg
		//if (method_exists('_h', "p")); if (method_exists(__CLASS__, "p"));
		array_unshift($args_, $method); //добавляем первым аргументом название тэга
		return call_user_func_array("_h::auto_tag", $args_);
	}

}

//z создал случайно, возможно он (hc) и не нужен

//html-content
function _hc($tag, $content = '', $attr_value = false, $attr_name = 'style'){
	return new _hc(func_get_args());
}
function is_hc($item){
	return $item instanceof _hc;
}
class _hc {
	var $init_args;
	function __construct($init_args) {
		$this->init_args = $init_args;
	}
	function __toString() {
		return call_user_func_array('_h::auto_tag', $this->init_args);
	}
	//статический метод, возращает новый {_hc}элемент
	static function __callStatic($method, $args_) {
		//d($method, $args_); if (x::decr('ctrl') <= 0) exit; //dbg
		//if (method_exists('_h', "p")); if (method_exists(__CLASS__, "p"));
		array_unshift($args_, $method); //добавляем первым аргументом название тэга
		return call_user_func_array("_hc", $args_);
	}
}