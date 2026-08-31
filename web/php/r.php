<?//6-7-20
_needphp('fileUrl', 'j', 'rootLess');
_needphp('useTemplate', 'camelize');


function r(){
	#/ q lazy cache
	$args = func_get_args();
	$R = new ReflectionClass('R');
	$R = $R->newInstanceArgs($args);
	return $R;
}
include PHP.'/r/r.class.php';
include PHP.'/r/rc.class.php';
include PHP.'/r/cr.php'; //wr, ar