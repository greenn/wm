<?#0.1.1
_needphp(
	//'s/init', - подстава с хранение пользователя в сессии
	'x',
	'dbg',
	'serialization'
);

_needphp('s/not_init');

define('SN_REM', 'rem');
if (!sHas(SN_REM)) s(SN_REM, array());

function rem(/*args-to-rem*/){
	$stack = s(SN_REM);
	//$stack = array();
	$id = rem_id();
	//$id = 0;
	//dx($stack, $id, isset($stack[$id]));
	//if (!isset($stack[$id]) || !is_array($stack[$id])) {
	if (!isset($stack[$id])) {
		$stack[$id] = array();
	}


	$stack[$id] []= serialize(func_get_args());
	s(SN_REM, $stack);
}

function _rems(){}
function rems(/*$id, args-to-rem*/){
	$args = func_get_args();
	$id = array_splice($args, 0, 1);
	//dx($id, $args);
	rem_id($id[0]);
	call_user_func_array('rem', $args);
}
function rem_id(/*?$id*/){
	static $id = 0;
	if ($q = func_num_args()) {
		$id = func_get_arg(0);
	}
	return $id;
}

function derem(/*?$id*/){
	$stack = s(SN_REM);
	if (func_num_args()) {
		$id = func_get_arg(0);
		if ($data = prop($stack, $id)) {
			print "<h4>$id</h4>";
			foreach ($data as $item) {
				$rem = try_unserialize($item);
				d($rem);
			}
		}
	} else {
		//d('--::set');
		derem_form::set();
		foreach ($stack as $id => $data) {
			derem($id);
		}
		print "<br /><h4>overall</h4>";
		d($stack, SN_REM, $_SESSION);
	}
}

function dxrem(){
	call_user_func_array('derem', func_get_args());
	exit;
}


class derem_form {

	static $nc = 'rem';
	static function css(){
		$n = self::$nc;
		print '<style type="text/css">';
		print <<<css
.$n H4, .$n H5 { margin: 0; }
css;
		print '</style>';
	}
	static function set(){
		self::css();
		print '<section class="'.self::$nc.'">';
		print '<a href="'.pagePath.'">refresh</a>';

		//ak self::submit() с-локальным-аргументами
		call_user_func_array('self::submit', func_get_args());

		print '<form method="post">';
		self::field_clear();
		print '</form>';

		//print '</section>';
	}

	static function submit(){
		//d('--::submit');
		if(!empty($_POST)) d($_POST);
		self::submit_clear();
	}

	static $submit_clear = 'rem_clear';
	static function field_clear(){
        $val = s(SN_REM);
	    if (empty($val)) return;
		echo '<br /><br />';
		echo '<input type="submit" name="'.self::$submit_clear.'" value="очистить все" />';
	}

	static function submit_clear(){
		if (isset($_POST[self::$submit_clear])) {
			s(SN_REM, array());
			echo "<h5>очищенно</h5>";
		}
	}
}