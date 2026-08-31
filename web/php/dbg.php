<?#1.1
_needphp('lib');
_lib('kint');
_needphp('dog');

class dbg {
	static function script_console($data, $title = ''){
		$json = json_encode($data);
		$arg_title = $title ? ", $title": '';
		return "<script>console.log({$json}{$arg_title})</script>";
	}

	static function pre($data, $title = '', $height = 100){
		$a_height = $height ? 'height="'.$height.'"' : '';
		$html_title = $title ? "<div><b>$title</b></div>" : '';
		$str_data = print_r($data, true);
		$str_data2 = var_export($data, true);

		ob_start();
		var_dump($data);
		$data = ob_get_clean();
		$str_data3 = var_export($data, true);

		return $html_title
			."<pre $a_height>$str_data</pre>"
			."<pre $a_height>$str_data2</pre>"
			."<pre $a_height>$str_data3</pre>"
		;
	}
}
