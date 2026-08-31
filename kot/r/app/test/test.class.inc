<?

_kot::reg('test', array(
	'nc' => array(
		'base' => 'tt'
	),
));

//для тестирования vue компонент
//вывод отдельный vue-ресурса

class kot_test extends kot {
	/*eg
		$paramsUri
			side-menu/v0/list-by?by=name
	*/
	static function url2ctx($paramsUri){

		$Pid = new pid($paramsUri);

		$rName = $Pid->get_part(1);
		$tplName = $Pid->get_part(2, true);
		$vueName = gi_key(0);

		return rb('vue', 'align_vue_args', array(
			'rName' => $rName,
			'tplName' => $tplName,
			'vueName' => $vueName,
		));
	}

}
