<?

_site::reg('uc', array(
	'nc' => array(
		'base' => 'UC'
	),
));

class site_uc extends site {
	static $lang = array(
		'uc-msg' => array('В разработке', 'Under construction'),
	);

	static function page($msg = true, $title = 'HTTP 404'){
		if ($title === true) $msg = _lang('uc-msg');
		return site('page', 'content', site_tpl('page', 'text', array(
			'title' => $title,
			'text' => site_tpl('uc', 'content', array('msg' => $msg)),
		)));
	}
}