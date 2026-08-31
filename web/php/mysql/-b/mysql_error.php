<?#0.0.3
function mysql_error(){
	$res = false;
	if (mysqli_connect_errno()) {
		$res = array(mysqli_connect_error(), mysqli_connect_errno());
	}
	return $res;
}

function mysql_error_for($Mysql){ //mysql_error_i|mysql_error_for|
	$res = false;
	if ($Mysql instanceof mysqli && $Mysql->connect_errno) {
		$res = array($Mysql->connect_error, $Mysql->connect_errno);
	}
	return $res;
}