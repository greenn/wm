<?

class tgbot {


	static function allUsers(){
		$fileList = dirToArray::apply(array(
			'path' => rb_tgbot::data_path($subDir),
			'keepDots' => false,
			'depth' => 0,
		));
		$fileList = dirToArray::excludePath($fileList, array(
			//'endsWith' => '-',
			'startsWith' => array('-'),
		));

		$list = array();
		foreach ($fileList as $filename => $path) {
			$list []= basename($filename, '.'.pathinfo($filename, PATHINFO_EXTENSION));
		}
		return $list;
	}
}