<?

_site::reg('error', array(
	'nc' => array(
		'base' => 'Er'
	),
));

class site_error extends site {
	static $lang = array(
		//'404' => array('Ошибка HTTP 404', 'HTTP 404'),
		'404-msg' => array('Страницы с таким адресом не существует'),
	);
}
