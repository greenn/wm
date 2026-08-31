<?#0.2
if (!is_callable('s')) {
	x('prevent_s_init', true); //[l т.к. в предыдущих версиях, s расчитана на автоматическое начало]
	_addphp('s');
}