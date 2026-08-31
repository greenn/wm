<?#0.2.1

_needphp(
	'set',
	'fq/_props',
	'isAssoc'
);


class image_fn { //image_fn|i_fn|
	static $mimeType = array(
		'image/jpeg' => 'jpg',
		'image/gif' => 'gif',
		'image/png' => 'png',
		'image/x-windows-bmp' => 'bmp',
		'image/tiff' => 'tiff',
	);
	static function getMime($type){
		$mime = array_search($type, image_fn::$mimeType);
		return $mime ? $mime : $type;
	}
	static function getType($path, $isMime = false){
		$mime = $isMime ? $path : prop(getimagesize($path), 'mime');
		return prop(image_fn::$mimeType, $mime, $mime);
	}

	//i_formatSize
	//tc
    static function formatSize($data, $format, $default = 1){
        if ($format === true) $format = $default;
        switch ((string)$format) {
            case '0': $format = array(0, 1); break;
            case '1': $format = array('w', 'h'); break;
            case '2': $format = array('width', 'height'); break;
            case 'str': $data = join('x', $data); break;
        }
        $result = $data;

        if (is_array($format)) {
			if (isAssoc($data)) {
				$data = array(
					prop($data, array('w', 'width'), 0),
					prop($data, array('h', 'height'), 0)
				);
			}
            $result = merge_keys_values($format, $data);
        }

		//d(func_get_args(), $format, array_values($data), $result);
        return $result;
    }


}