<?#0.3.6

include_once PHP.'/need/need.class.php';
need::init('need/need.class');

function _needphp(/*$phpName, $phpName*/) {
	foreach (func_get_args() as $phpName) {
		//echo $phpName, '<br />';
		need::php($phpName);
	}

}

function _addphp($phpName) {
	need::php($phpName);
}

function _lib($phpName) {
	need::lib($phpName);
}

	//L
	function _needinc($incName) {
		need::inc($incName);
	}