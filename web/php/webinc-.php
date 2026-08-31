<?//4-12
_needphp('undef');

function webinc($incPathName, $set = array(), $reuse = true){
	$incResult = undef();
	if (is_string($incPathName)) {
	    //d($incPathName, $set);
		$set = (object)$set;
		$phpIncludePath = WEB.'/inc/'.$incPathName.'.inc';
		if (is_file($phpIncludePath)) {
			ob_start();
			if ($reuse) {
				include ($phpIncludePath);
			} else {
				include_once ($phpIncludePath);
			}
			$incResult = ob_get_clean();
		}
	}
	return $incResult;
}



/*



*/

/*

	if (is_array($incArguments)){
		extract($incArguments);
	}

*/