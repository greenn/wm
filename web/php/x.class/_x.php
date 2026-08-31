<?#1.7.0

_needphp('x.class');

function _x(){
	switch (func_num_args()) {
		case 0;
			return x::get_list();

		case 1:
			$varName = func_get_arg(0);
			return x::get($varName);

		case 2:
			$varName = func_get_arg(0);
			$varValue = func_get_arg(1);
			return x::set($varName, $varValue);

		case 3:
			$varName = func_get_arg(0);
			$funcArg = func_get_arg(1);
			$funcName = func_get_arg(2);

			switch ($funcName) {
				case 'delete': {
					return x::delete($varName);
				}
			}

			return null;
	}
}