<?

$Self = _rb::reg('page', array(
	'nc' => array(
		'base' => 'Pg'
	),
));

class rb_page extends rb {

	/*
		'favicon' => array(
			'generator' => 'gen2', //r/rb/page/head/favicon-gen2.tpl.php
			'dir' => pik_i::name('favicon/01', true),
		),
	*/
	static function favicon($cfg){
		$res = '';
		if ($cfg) {
			if (is_array($cfg)) {
				$gen = prop($cfg, 'generator');
				//dx($cfg, $gen);
				if ($gen && static::hasTpl("head/favicon-$gen")) {
					$res = static::tpl("head/favicon-$gen", $cfg);
				} else {
					$res = static::tpl('head/favicon-pack', $cfg);
				}
			} else {
				$res = static::tpl('head/favicon', array('href' => $cfg));
			}
		}
		return $res;
	}

	static function webkit($names){
		static::call('webkit/main', array(
			'req' => (array) $names
		));
	}
}
