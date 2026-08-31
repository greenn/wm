<?#2.13.0

function webreq($incPathName){ //ak webinc
	if (is_string($incPathName)) {
		$phpIncludePath = WEB.'/inc/'.$incPathName.'.inc';
		if (is_file($phpIncludePath)) {
			require_once ($phpIncludePath);
		}
	}
}

/*
function webreq($incPathName, $set = array()){
	if (is_string($incPathName)) {
		$set = (object)$set;
		$phpIncludePath = WEB.'/inc/'.$incPathName.'.inc';
		if (is_file($phpIncludePath)) {
			require_once ($phpIncludePath);
		}
	}
}
*/