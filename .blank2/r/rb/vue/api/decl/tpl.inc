<?

_needphp('qtpl.class');

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	//'type' => 'guest'
	'path' => '', #eg: rp/id/mod-test

));


$path = $_ctx['path'];
$chunks = explode('/', $path);
$r = array_shift($chunks);
$name = array_shift($chunks);
//$act = array('path', implode('/', $chunks));
$arg = implode('/', $chunks);


$vueId = basename($arg);

$tplPath = r_($r, $name, 'path', $arg, 'vue.tpl.inc');
$tpl = r_($r, $name, 'tpl', $arg, array('id' => $vueId), 'vue.tpl.inc');
//dx($r, $name, $arg, $tplPath, is_file($tplPath), $tpl);
//include $jsPath;

//rt_api::$outputMethod = 'outputJs';
return array(
	'vue-name' => $vueId,
	//'vue-tpl' => $tpl,
	'vue-tpl-script' => join(newline, array(
		'<script type="text/x-template" id="'.$vueId.'">',
			$tpl,
		'</script>',
	)),

);



##              dd
//$res = _r_($r, $act);
//dx($r, $res, is_file($res));
//r_($r, 'path', $arg)
//r__($Args)
//_r_('rt', func_get_args());

