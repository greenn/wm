<?#3.0.1

_rb::reg('wd', array(
	'nc' => array(
		'base' => 'WD'
	),
));


if (gt('hkmax')) {
	//dx(gt('hkmax'));
	_x('hkWdFakeImgMax', gt('hkmax'));
}

class rb_wd extends rb {

	static $typeMap = array(
		'def' => 'v1/wd',

		'1' => 'v1/wd', //base - по src
		'1b' => 'v1b/wd',
		'1c' => 'v1c/wd',
		//'2' => 'v2/wd',
	);

	static function getPreset($name, $ctx = array()){
		//return static::call("preset/$name", $ctx);
		//return static::call("preset/$name", $ctx);
		$wdDir = cur('wdDir');

		$path = "$wdDir/$name.inc";
		//dx($path, is_file($path));
		$result = inc($path, INC_RES_AS_DATA);
		//dx($path, is_file($path), $result);
		return $result;
	}

	static function take_id($src, $ext = '.png') {
		return preg_replace("/[^a-z0-9]/i", '-', basename($src, $ext));
	}

	//получение preset опций
	static function preset_ctx($name, $extend = array()){ //, $update
		$ctx = static::getPreset($name);
		if (!$ctx) {
			$ctx = array(
				'img' => "$name.png",
				'id' => "$name",
			);
		}

		if ($extend) $ctx = array_replace($ctx, $extend);
		return $ctx;
	}

	//mvd rb/vue/vue.class.inc
	static function vue_test($cmpt, $isHtml = false){
		//L
		return rb('vue', 'vue_test', $cmpt, $isHtml);
	}

	static function css_v1($n, $id, $imgData, $ctx = array()){
		$par_css = array(
			'width' => $imgData['w'].'px',
			'height' => $imgData['h'].'px',
		);
		$src_css = array(
			'background-image' => "url('{$imgData['src']}')",
		);

		return join("\n", array(
			static::cssRule("#$id", $par_css),
			static::cssRule("#$id > .$n-view > .$n-src", $src_css),
		));
	}

	static function css_v1c($n, $id, $imgData, $ctx = array()){
		$par_css = array(
			'width' => $imgData['w'].'px',
			'height' => $imgData['h'].'px',
		);
		$src_css = array(
			'background-image' => "url('{$imgData['src']}')",
		);

		return join("\n", array(
			static::cssRule("#$id .$n-view", $par_css),
			static::cssRule("#$id > .$n-view > .$n-src", $src_css),
		));
	}

	static function cssRule($sr, $rules){
		static $RULE_EOL = ";\n";
		if (isAssoc($rules)) {
			$_rules = array();
			foreach ($rules as $prop => $val) {
				$_rules []= "$prop: $val";
			}
			$rules = $_rules;
		}
		$css = join($RULE_EOL, $rules).$RULE_EOL;
		return "$sr {\n".$css."\n}\n";
	}

	static function fake($name, $aq = 'mc'){
		return static::tpl('fake', array(
			'img' => $name,
			'aq' => $aq,
		));
	}

	static function fake_src($src, $host = ''){
		return static::tpl('fake-src', array(
			'src' => $src,
			'host' => $host,
		));
	}
}
