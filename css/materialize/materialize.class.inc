<?
_rt::reg('css/materialize', array(
	'className' => 'css_materialize',
	//'classFile' => __FILE__,
	//'rDir' => dirname(__FILE__),
	//'rClass' => __FILE__,
));

/*
	css/materialize/materialize.css.inc
	css/materialize/materialize.class.inc
*/

class css_materialize extends rt {
	static function req($css = true, $js = true, $min = null){
		if (is_null($min)) $min = productionMod;
		$v = '1.0.0';
		$min = $min ? '.min' : '';
		if ($css) static::req_css(array("$v/css/materialize{$min}.css"));
		if ($js) static::req_js(array("$v/js/materialize{$min}.js"));
	}
}