<?

$Self = _rb::reg('vue', array(
	//'className' => 'rp_vue',
	//'rDir' => dirname(__FILE__),
	'nc' => array(
		'base' => 'Vu'
	)
));

//dx($r);

class rb_vue extends rb {

	static function jsCollectStylesInBody(){
		ob_start(); ?>
$(function() {
	var $stylesFromBody = $('BODY STYLE');
	$('HEAD').append($stylesFromBody);
})
		<? js::req(-1, false, false, ob_get_clean());
	}

	static function insert($vueCtx, $rClass, $rName, $tplName, $tplCtx = true){
		vue::req($rClass, $rName, $tplName, $tplCtx, $vueCtx);
		if (!is_array($vueCtx)) $vueCtx = array('id' => $vueCtx);
		return static::tpl('insert', $vueCtx);
	}

	//Вставляем в #app-враппер vue-комоненнту $cmpt с атрибутами $attr
	// и инициализируем запуск vue-приложения
	static function vue_test($cmpt, $isHtml = false){
		/*
			r__(array('rp', 'login', 'req_vue',  $rule?, $tplName, $tplCtx, $vueCtx))
			r__(array('rp', 'app', 'vue_req', 'header',  'header', []*))
		*/
		$attr = array();
		if (isOrdinal($cmpt)) {
			$attr = $cmpt[1];
			$cmpt = $cmpt[0];
		}

		$html = $isHtml ? $cmpt : rb_tpl('vue', 'insert', array(
			'name' => $cmpt,
			'attr' => $attr,
		));
		$tpl = join(newline, array(
			'<div id="app">',
				$html,
			'</div>',
		));

		_rb::req_js('vue', 'app-init');

		return $tpl;
	}

	static function req($sName){
		$args = func_get_args();
		foreach ($args as $sName) {
			if (in_array($sName, array(
				's-toggle', 's-icon', 's-field', 's-button'
			))) {
				list($dir, $name) = explode('-', $sName);
				static::vue_req($sName, "$dir/$name/$sName");
				//static::vue_req('s-toggle' ,'s/toggle/s-toggle');
			}
		}
	}

	static function req_v1($name){
		$args = func_get_args();
		foreach ($args as $name) switch ($name) {
			case 's-toggle':
				static::vue_req('s-toggle' ,'s/toggle/s-toggle');
			break;
			case 's-icon':
				static::vue_req('s-icon' ,'s/icon/s-icon');
			break;
			case 's-field':
				static::vue_req('s-field' ,'s/field/s-field');
			break;
			case 's-button':
				static::vue_req('s-button' ,'s/button/s-button');
			break;
		}
	}

	static function align_vue_args($ctx, $ordinalResponse = false){
		$rName = prop($ctx, 'rName');
		$tplName = prop($ctx, 'tplName');
		$vueName = prop($ctx, 'vueName');

		if (!$vueName) {
			$lastSlashPos = strrpos($tplName, "/");
			if ($lastSlashPos !== false) { //case: есть слэши в $tplName
				$vueName = substr($tplName, $lastSlashPos + 1);
			} else {
				$vueName = $rName;
			}
		}
		if (!$tplName) $tplName = $rName;

		return $ordinalResponse ? array($rName, $tplName, $vueName) : array(
			'rName' => $rName,
			'tplName' => $tplName,
			'vueName' => $vueName,
		);
	}
}

function _vue(/*args*/){
	return call_user_func_array('rb_vue::insert', func_get_args());
}
/*
	_vue('app-footer', 'rp', 'app', 'footer')
	rb_vue::insert('app-footer', 'rp', 'app', 'footer')
	rb('vue', 'insert', 'app-footer', 'rp', 'app', 'footer')
	r_tpl('app', 'footer')
		<?
		$Self = _rp::self();
		$Self::vue_req('app-footer', 'footer');
		?>
		<app-footer></app-footer>
*/


_needphp('qtpl.class');
function vue_source_html($path, $join = true){
	$output = array('js' => '', 'tpl' => '');

	$dir = dirname($path);
	$name = basename($path);

	$jsExt = 'vue.js.inc';
	$tplExt = 'vue.tpl.inc';
	$jsFile = "$dir/$name.$jsExt";
	$tplFile = "$dir/$name.$tplExt";
	//return dx($name, is_file($jsFile), is_file($tplFile));

	$js = qtpl::apply_path($jsFile);;
	$tpl = qtpl::apply_path($tplFile);;

	if ($js) {
		$output['js'] = array(
			'<script type="text/javascript">',
				$js,
			'</script>',
		);
	}
	if ($tpl) {
		$output['tpl'] = array(
			'<script type="text/x-template" id="'.$name.'">',
				$tpl,
			'</script>',
		);
	}

	return !$join ? $output : join(newline2, array(
		join(newline, $output['tpl']),
		join(newline, $output['js']),
	));
}
