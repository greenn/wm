<?#0.3.2

function redirect($url, $track_info = true){
	if ($track_info) redirect_info::add($url);
	header('Location: '.$url);
	exit;
}

	//dd
	function redirect_with_ref($url){
		//проверка есть ли в $url уже есть query
		redirect('/login?ref='.urlencode(URI));
	}

function redirect_info(){
	switch (func_num_args()) {
	 	default: return redirect_info::data();
	}
}

class redirect_info {
	static $ns = 'redirect_info'; //session variable name
	static $gtClear = 'clear_redirect_info'; //get-parameter variable name - ?clear_redirect_info
	static function verify(){
		if (session_id()) {
			if (!isset($_SESSION[static::$ns])) {
				$_SESSION[static::$ns] = array();
			}
			return true;
		}
		return false;
	}
	static function add($url){
		if (static::verify()) {
			$_SESSION[static::$ns] []= $url;
		}
	}
	static function data(){
		return static::verify() ? $_SESSION[static::$ns] : null;
	}

	static function clear(){
		if (static::verify()) {
			$_SESSION[static::$ns] = array();
		}
	}
	static function last(){
		$rec = null;
		if ($stack = static::data()) {
			$rec = end($stack);
		}
		return $rec;
	}
}

//::

if (isset($_GET[redirect_info::$gtClear])) {
	redirect_info::clear();
	redirect(str_replace(array(
		'?'.redirect_info::$gtClear,
		'&'.redirect_info::$gtClear,
		redirect_info::$gtClear,
	), '', URL), false);
}