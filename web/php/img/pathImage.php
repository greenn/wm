<?#0.2.1 - helper/комбайнер по работе с изображением
_needphp(
	'fq/_is',
	'img/fn',
	'img/resize'
);

class pathImage {
	var $path;
	var $filename;
	var $type; //ak ext
	var $width;
	var $height;
    var $set;
	function __construct($path, $set = null) {
        //dx(is_file($path), $path);
        if (!is_file($path)) return;

        $this->set = $set = set($set);
		//$this->set_path($path);
		$this->path = $path;
		$this->filename = basename($path);
		$this->dir = dirname($path);

		list($this->width, $this->height) = $inf = getimagesize($path);
		$this->type = image_fn::getType($inf['mime'], true);

	}
	//private function set_path($path){}

	function size($format = false) {
        $sizes = array($this->width, $this->height);
        return is_stringable($format) ? image_fn::formatSize($sizes, $format, 1) : $sizes;
	}

	var $gd;
	function gd(){
		if (!$this->gd) {
			$this->gd = gd_fn::createFromPath($this->path);
		}
		return $this->gd;
	}

    var $Gd; //ff $Gd->resize()

    function resize($reqSize/*|$resConf*/, $opts = true){
        $srcConf = array(
            'width' => $this->width,
            'height' => $this->height,
            'type' => $this->type,
            'gd' => $this->gd()
        );

        $opts = merge(array(
            //'saveBaseDir' => $this->dir,
            //'stretch' => false
            'baseDir' => $this->dir,
            'name' => $this->filename
        ), $opts);

		return i_resize($srcConf, $reqSize, $opts);
    }

    function genUid($prefix = ''){
    	$content = file_get_contents($this->path);
    	$uid = hash('adler32', $content);
    	if ($prefix) $uid = $prefix.$uid;
    	return $uid;
    }
}
