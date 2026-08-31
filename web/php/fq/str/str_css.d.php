<?//dd

/*
	by
		php/rp/rp_shandler.class.php
*/

static function str_css($css_data, $css_add = null){ //css_styles|str_css|
	if (is_array($css_data)) {
		$styles = array();
		if (isOrdinal($css_data)) {
			$styles = array_merge($styles, $css_data);
		} else {
			foreach ($css_data as $val => $prop) {
				$styles []= "$val: $prop";
			}
		}
		$styles = join('; ', $styles);
	} else {
		$styles = $css_data ? (string) $css_data : '';
	}


	if ($css_add) {
		if ($css_add = static::str_css($css_add)) {
			$styles .= ';'.static::str_css($css_add);
		}
	}
	return $styles;
}