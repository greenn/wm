<?

_site::reg('app', array(
	'nc' => array(
		'base' => 'A'
	),
));

class site_app extends site {
	
	
	static function handleAppCtx($ctx){
		if ($ctx || is_array($ctx)) {
			if ($ctx === true) $ctx = '';

			if (is_array($ctx)) {
				$_app = array();
				foreach ($ctx as $prop => $value) {
					$_app []= "$prop=".urlencode($value);
				}
				$ctx = join('&', $_app);
			}

			static::req_js(2, 'site-app'.($ctx ? '?'.$ctx : ''));

			static::collectStylesInBody();
		}
	}
	
	
	static function collectStylesInBody(){
		ob_start(); ?>
$(function() {
	var $stylesFromBody = $('BODY STYLE');
	$('HEAD').append($stylesFromBody);
})
		<? js::req(-1, false, false, ob_get_clean());
	}
}
