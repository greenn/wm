<?php





class gd_fn {

	static function pixelInfo() {}
	static function isLineTransparent() {}
	static function bitmap() {}
	//static function map4jspic() {}

	//dd1

	var $src;

	var $set;
	function __construct($data, $set) {
		$this->set = $set = set($set);
		if (is_string($data)) {
			$path = $data;
			//$this->
		} else {
			//ff $path = $w, $h, $type
		}
	}

	//\dd1
}

-   -   -   -
class pathImage {
	var $path;
	var $type;
	var $width;
	var $height;
	function __construct($path) {

	}

	/*
		->size(array('w', 'h'))
		->size(true)
		->size('height')
	*/
	function size($names = false) {
		return image_fn::picSize($names, array($this->width, $this->height));
	}
}

class image_fn {

	static function picSize($conf, $sizes){
		if ($conf === true) $conf = array('width', 'height');
		elseif (is_string($conf)) $conf = array($conf);
		return $conf ? merge_keys_values($conf, $sizes) : $sizes;
	}
}

-   -   -   -

	class image {
		function __construct() {
			$args = func_get_args();

		}
		function create(){}
		function createFromPath(){}
	}




//-	-	-	-


class image_d {

    var $gd;
    var $type;
    var $width;
    var $height;
    function size($named = false){
        $size = array($this->width, $this->height);
        if ($named === true) $named = array('width', 'height');
        elseif (is_string($named)) $named = array($named);
        return $named ? merge_keys_values($named, $size) : $size;
    }


    function __construct($set) {

        if (func_num_args() > 1) {
            list($w, $h, $set) = func_get_args();
        } else if (is_string($set)) {
            $path = func_get_arg(0);
            $this->gd = $this->createFromPath($path);
        }

    }


    function createFromPath($path) {

    }
}


