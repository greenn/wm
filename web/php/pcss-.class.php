<?

class pcss {

	/*
		pcss::gradientVal(array('#f4f2ee', '#b6cad1'));
		pcss::gradientVal(array(0 => '#f4f2ee', 65 => '#d6e1e4', 100 => '#b6cad1'));
	*/
	static function gradientVal($colors){
		if (isAssoc($colors)) {
			foreach ($colors as $pct => &$val) {
				$val = "$val $pct%";
			}
		}
		return join(', ', array_values($colors));
	}

}