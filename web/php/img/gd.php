<?#1.1

_needphp(
	'set',
	'fq/_props',
	'isAssoc',
	'img/fn'
);


function i_gd($data, $set = false){
	$Gd = new gdImage($data, $set);
	return $Gd;
}

//0
function i_resource($data, $set = false){
    $Gd = new gdImage($data, $set);
    return $Gd->image;
}


class gdImage {

	var $set;

	var $image;
	var $type;
	var $width;
	var $height;

	function __construct($data, $set = false) {
		$this->set = $set = set($set);
		if (is_string($data)) { //case: gdImage($path)
			$this->createFromPath($data);
		} elseif (is_array($data)) {
            if (!isset($data['type']) || !isset($data['width']) || !isset($data['height'])) {
                throw new Exception('Недостаточно данных для создание gdImage');
            }
            if (isset($data['gd'])) {
                //case: gdImage({a[gd, type, w, h]})
                $this->setImage($data['gd'], $data['type'], $data['width'], $data['height']);
            } else {
                //case: gdImage({a[type, w, h]}
                $this->create($data['type'], $data['width'], $data['height']);
            }
		}
	}

    function setImage($gd, $type, $width, $height){
        $this->clean();
        $this->image = $gd;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
    }


    var $pathFrom;
    function createFromPath($path){
        list($this->width, $this->height) = $inf = getimagesize($path);
        //$this->type = image_fn::getType($path);
        $this->type = image_fn::getType($inf['mime'], true);
        $this->pathFrom = $path;
        $this->clean();
        $this->image = gd_fn::createFromPath($this->pathFrom, $this->type);
    }

    var $isTransparent;
    private static $allowTransparentTypes = array('gif', 'png');
    function create($type, $width, $height, $isTransparent = true){

        $this->type = $type;
        $this->width = $width;
        $this->height = $height;

        $this->clean();
        if (in_array($this->type, $this::$allowTransparentTypes)) {
            $this->isTransparent = $isTransparent;
            $this->image = gd_fn::create($this->type, $this->width, $this->height, $this->isTransparent);
        } else {
            $this->image = gd_fn::create($this->type, $this->width, $this->height);
        }
    }

    function clean(){
        if ($this->image) {
            imagedestroy($this->image);
            $this->image = null;
        }
    }

	var $pathSaved;
    function save($path, $clean = true){
        gd_fn::save($this->type, $this->image, $path, $clean);
		$this->pathSaved = $path;
    }
    function output($clean = true){
        gd_fn::output($this->type, $this->image, $clean);
    }
    function content($clean = true){
        return gd_fn::content($this->type, $this->image, $clean);
    }
    function tag($alt = '', $css = ''){
        return gd_fn::tag($this->image, $alt, $css);
    }


    //dd
    function fill ($w, $h){

        //stackoverflow.com/questions/4023441/how-to-get-image-resource-size-in-bytes-with-php-and-gd


        $image = jpg_fn::create($w, $h);
        $rgb = array(255, 255, 255);
        $white = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
        //1
        imagefilledrectangle($image, 0, 0, $w, $h, $white);
        //2
        imagefill($image, 0, 0, $white);
    }
}


class gd_fn {

	static $classMap = array(
		'jpg' => 'jpg_fn',
		'jpeg' => 'jpg_fn',
		'gif' => 'gif_fn',
		'png' => 'png_fn',
	);
	static function imgClass($type){
		return prop(gd_fn::$classMap, $type);
	}

	static function create($type, $w, $h, $isTransparent = true){
		$imgClass = static::imgClass($type);
		$gd = $imgClass::create($w, $h, $isTransparent);
		return $gd;
	}

	static function createFromPath($path, $type = true){
		$type = !is_string($type) ? image_fn::getType($path) : $type;
		$imgClass = static::imgClass($type);
		$gd = $imgClass::createFromPath($path);
		//$gd = call_user_func("$imgClass::createFromPath", $path);
		//$gd = call_user_func(array($imgClass, 'createFromPath'), $path);
		return $gd;
	}

	static function content($type, $gd, $clean = false) {
		ob_start();
		static::output($type, $gd, $clean);
		return ob_get_clean();
	}

	static function tag($gd, $alt = '', $css = '') {
		$styles = $css ? ' style="'.$css.'"' : '';
		return '<img'.$styles.' src="data:image/png;base64,'.base64_encode(static::content($gd)).'" alt="'.$alt.'" />';
	}

	//-не работает
	static function save_($gd, $path, $clean = true){
		imagegd($gd, $path);
		if ($clean) imagedestroy($gd);
	}
	static function save_2($gd, $path, $clean = true){
		imagegd2($gd, $path);
		if ($clean) imagedestroy($gd);
	}

    //получение типа из gd
    //https://stackoverflow.com/questions/2207095/get-image-mimetype-from-resource-in-php-gd

	static function save($type, $gd, $path, $clean = true){
		$imgClass = static::imgClass($type);
		$imgClass::save($gd, $path, $clean);
	}

	static function output($type, $gd, $clean = true){
		$imgClass = static::imgClass($type);
        $imgClass::output($gd, $clean);
	}

	//dd
	static function resize($srcConf, $resConf, $conf){
		$src = set(array(

		), $srcConf);
		$res = set(array(

		), $resConf);
		$set = set($conf);

	}
}

class png_fn {

	static function create($w, $h, $isTransparent = true){
		$img = imagecreatetruecolor($w, $h);
		if ($isTransparent) {
			imagealphablending($img, false);
			imagesavealpha($img, true);
			$transparent = imagecolorallocatealpha($img, 255, 255, 255, 127);
			imagefill($img, 0, 0, $transparent);
			imagecolortransparent($img, $transparent);
		}
		return $img;
	}

	static function createFromPath($path){ //image|createFromPath|
		$png = imagecreatefrompng($path);
		imagealphablending($png, false); //false = дабы использовать только собственныое значение альфы, +нужен для imagesavealpha
		imagesavealpha($png, true); //сохранять всю информацию альфа компонента (в противовес одноцветной прозрачности)
		return $png;
	}

	static function save($gd, $path, $clean = true){
		imagepng($gd, $path);
		if ($clean) imagedestroy($gd);
	}

	static function output($gd, $clean = true){
		imagepng($gd);
		if ($clean) imagedestroy($gd);
	}

}

class gif_fn {

	static function create($w, $h, $isTransparent = true){
		return png_fn::create($w, $h, $isTransparent);
	}

	static function createFromPath($path){
		$gif = imagecreatefromgif($path);
		$transparent_index = imagecolortransparent($gif); //Если в изображении нет прозрачных цветов, фунция вернет -1.
		if ($transparent_index != -1) { //Дальше пока непонятная магия ☺
			$component = imagecolorsforindex($gif, $transparent_index); // Get the original image's transparent color's RGB values
			$transparent = imagecolorallocate($gif, $component['red'], $component['green'], $component['blue']); // Allocate the same color in the new image resource
			imagefill($gif, 0, 0, $transparent); // Completely fill the background of the new image with allocated color.
			imagecolortransparent($gif, $transparent); // Set the background color for new image to transparent
		}
		return $gif;
	}

	static function save($gd, $path, $clean = true){
		imagegif($gd, $path);
		if ($clean) imagedestroy($gd);
	}

	static function output($gd, $clean = true){
		imagegif($gd);
		if ($clean) imagedestroy($gd);
	}
}


class jpg_fn {

	static function create($w, $h){
		$img = imagecreatetruecolor($w, $h);
		return $img;
	}

	static function createFromPath($path){
		$jpg = imagecreatefromjpeg($path);
		return $jpg;
	}

	static function save($gd, $path, $clean = true){
		imagejpeg($gd, $path);
		if ($clean) imagedestroy($gd);
	}

	static function output($gd, $clean = true){
		imagejpeg($gd);
		if ($clean) imagedestroy($gd);
	}
}