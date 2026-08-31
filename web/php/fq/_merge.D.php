<?# deprecated merge functions
/*
	не уверен что они нормально работают
		либо отказаться
		либо починить

*/


//хелпер для array_merge: несколько переменных, перевод в array()
// походу он и так мерджит несколько переменных
//  так что удобство в том, что этот пропускает bool/null
//[eg] web/test/web/php/fq/merge.php
/* [pr-1 плохо делает]
	dx(
		merge($test1, array('nick' => $test1['nick'].' 2')),
		array_merge($test1, array('nick' => $test1['nick'].' 2'))
	);

*/
function merge(/*$arg1, $argN*/){
	$res = array();
	if (func_num_args()) {
		$args = func_get_args();
		$res = false; //указывает, что предыдущий аргумент, может быть не массив
		foreach ($args as $arg) { //проходимся по всем поступившем аргументом

			if (is_bool($arg) || is_null($arg)) $arg = array();
			else if (!is_array($arg)) $arg = (array) $arg;

			if (!$res) $res = $arg; //case first item
			else {
				//dx($res, $arg, array_merge_recursive($res, $arg));
				$res = array_merge_recursive($res, $arg);
			}
		}
	}

	return $res;
}


/*
	 rmerge($a, 11);
*/
//0t
function rmerge(&$result){
	return $result = call_user_func_array('merge', func_get_args());
}


//0t
function extend(/*$arg1, $argN*/){
	$res = array();
	$args = func_get_args();
	if (func_num_args()) {
		$res = false;
		foreach ($args as $arg) {

			if (is_bool($arg) || is_null($arg)) $arg = array();
			else if (!is_array($arg)) $arg = (array) $arg;

			if (!$res) $res = $arg; //case first item
			else {
				//dx($res, $arg, array_merge_recursive($res, $arg));
				$res = array_replace_recursive($res, $arg);
			}

		}
	}

	return $res;
}