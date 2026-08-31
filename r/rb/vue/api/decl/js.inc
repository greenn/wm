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


$jsPath = r_($r, $name, 'path', $arg, 'vue.js.inc');
//dx($r, $name, $arg, $jsPath, is_file($jsPath));
//include $jsPath;

rt_api::$outputMethod = 'outputJs';
return qtpl($jsPath);



##              dd
//$res = _r_($r, $act);
//dx($r, $res, is_file($res));
//r_($r, 'path', $arg)
//r__($Args)
//_r_('rt', func_get_args());

