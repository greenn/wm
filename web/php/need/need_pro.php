<?#0.1.1


function need_pro(){
	foreach (func_get_args() as $phpName) {
		need::pro($phpName);
	}
}