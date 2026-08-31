<?#0.2.1



if (!is_callable('s_init')) {
	_addphp('s'); //сессия стартуется при загрузке обвеса [pp/l - hb/rd]
	//dx(is_callable('s_init'));
}

if (!s_inited()) s_init();

//dx(s_inited(), is_callable('s_init'));