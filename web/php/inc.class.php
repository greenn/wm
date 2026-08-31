<?#6.4.17

class inc {

	static function raw($path/*, $ctx*/){ //|asData|raw

	}
	static function data($path/*, $ctx*/){ //|asData|asData
		if (func_num_args() > 1) $ctx = func_get_arg(1);
		return include $path;
	}
}