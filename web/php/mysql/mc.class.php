<?#0.2.19 - mysql connection / helper для доступа в глобальному mysql-подключению


_needphp(
	'mysql/mysql.class'
);

class mc {
	static $mysql;

	static function __callStatic($method, $args_) {
		return call_user_func_array(array(static::$mysql, $method), $args_);
	}
}

function mc($className, $method/*, $arg1, $argN*/){
	return call_user_func_array(array($className, $method), array_slice(func_get_args(), 2));
}