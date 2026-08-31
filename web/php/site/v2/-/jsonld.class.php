<?#2.1.0

class jsonld extends stacker {


	static $data = array();

	static function add($dataName, $dataCtx){
		static::$data[$dataName] = $dataCtx;

		$args = func_get_args();
		return static::push($args);
	}
}


class _jsonld {
	static $typeMap = array( // @type =>
		'logo' => 'ImageObject',
	);

	static $relMap = array( // @type =>
		'logo' => 'organisation/logo',
	);

}