<?//1-2



function def($name = null, $value = null){
	static $stats = array();
	$args = func_get_args();
	$qArgs = func_num_args();
	$qName = $qArgs > 0;
	$qVal = $qArgs > 1;
	$res = null; #|| $res = $value;
	
	if (!$name) 
		return $res;

	if ($qName &&! $qVal) {
		$res = defined($name) ? constant($name) : $value;
	}

	if ($qVal) {
		if (!defined($name)) {
			define($name, $value);

			$res = $value;
		} else {
			$res = constant($name);
			
			
			$name = serialize($args);

			$ctx = null;
			if (isset($stats[$name])) {
				$ctx = $stats[$name];
			} else {
				$stats[$name] = array();
				$stats[$name]['qty'] = 0;
			}

			$o = (object) $ctx;
			$o->qty++;
		}

	}
	
	return $res;
}

//комментария что она делает и где применяется