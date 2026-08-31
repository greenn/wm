<?#0.2.0


function chmodVal($val, $defVal = 0755){
	if ($val === true) $val = $defVal;
	return is_string($val) ? intval($val, 8) : $val;
}
