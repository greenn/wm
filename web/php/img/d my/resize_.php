<?php
//v0.6
/* [E]
    Fatal error: Allowed memory size of 67108864 bytes exhausted (tried to allocate 11648 bytes) in /web/htdocs/www.baranava.it/home/hanna/qcms/__/img.php on line 15
*/

# Сохраняет в $destPath resize картинки $filePath по заданному размеру $size
//resize($path1, $path2, '100x200');
//resize($path1, $path2, '100x~'); высота возьмёться относительно пропорций $path1
function resize($filePath, $destPath, $size) { //0.6
#$debug = t; if ($debug){ $size='~600x~600'; $filePath=$filePath; $destPath=$destPath; }
	list($w2, $h2) = is_string($size)? explode('x', strtolower($size)) : $size;
	list($w1, $h1) = $info = getimagesize($filePath);
	list($isP, $isL) = array(($w2<$h2), ($w2>$h2)); //isPortrait, isLandsscape

	if( #modified Sized - если в параметре присуствует знак тильды ~
		($wm = ($w2[0]=='~')?(strlen($w2)==1?true:substr($w2, 1)):false) //modified Width
		+ ($hm = ($h2[0]=='~')?(strlen($h2)==1?true:substr($h2, 1)):false) //modified Height
		+ ($code = var2dstr($wm).var2dstr($hm))
	){ #тогда размеры вычисляем на их основе
		switch($code) {
			case '11': return copy_file($filePath, $destPath); # ~ x ~
			case '01': { # D x ~
				$h2 = round($h1*$w2/$w1);
			} break;
			case '10': { # ~ x D
				$w2 = round($w1*$h2/$h1);
			} break;
			case '12': { # ~ x ~D
				$h2 = ($h1>$hm)? $hm : $h1;
				$w2 = round($w1*$h2/$h1);
			} break;
			case '21': { # ~D x ~
				$w2 = ($w1<$wm)? $w1 : $wm;
				$h2 = round($h1*$w2/$w1);
			} break;
			case '20': { # ~D x D
				$w2 = round($w1*$h2/$h1);
				if ($w2 > $wm) { $w2 = $wm;
					$h2 = round($w1*$w2/$h1);
				}
			} break;
			case '02': { # D x ~D
				$h2 = round($w1*$w2/$h1);
				if ($h2 > $hm) { $h2 = $hm;
					$w2 = round($w1*$h2/$h1);
				}
			} break;
			case '22': { # ~D x ~D
				$w2 = ($wc=($w1>$wm))? $wm : $w1;
				$h2 = ($hc=($h1>$hm))? $hm : $h1;
				if ($wc&&$hc){
					$ht = round($h1*$w2/$w1);
					$wt = round($w1*$h2/$h1);
					if ($wt <= $wm) $w2 = $wt; else $h2 = $ht;
				}
				elseif($wc) $h2 = round($h1*$w2/$w1);
				elseif($hc) $w2 = round($w1*$h2/$h1);
				else return copy_file($filePath, $destPath);
				/*
				$sW = $img->w > 1600? '1600x~' : false;
				$sH = $img->h < 1200? '~x1200' : false;
				if ($sW||$sH) { //Нужен ли ресайз
					$r3size = $img->isPortrait? ($sH?$sH:$sW) : ($sW?$sW:$sH); //Если картинки портетная, то сначала проеверяем высоту, если например картинка большая по обоим параметрам, то она может направильно сресаёзится, если не проверять на её ориентированность (Портератная или Панорамная)
					$r3 = resize($img->original, $img->view, $r3size);
				} $r3 = copy_file($img->original, $img->view);
				*/
			} break;
		}
	} #else работает с заданными величинами


//if($debug) echo big(b($size)).br.$w1.'x'.$h1.' ~ ['.b($size).']'.sup(':'.$code).' = '.$w2.'x'.$h2.br;
	$im2 = imagecreatetruecolor($w2, $h2);

	switch ($info['mime']) {
		case 'image/png': {
			$im1 = imagecreatefrompng($filePath);
			imagealphablending($im1, false);
			imagesavealpha($im1, true);
			$resizeMethod = 'imagecopyresampled';
			imagealphablending($im2, false);
			imagesavealpha($im2, true);
			$transparent = imagecolorallocatealpha($im2, 255, 255, 255, 127);
			//imagefilledrectangle($im2, 0, 0, $w2, $h2, $transparent);
			imagefill($im2, 0, 0, $transparent); // Completely fill the background of the new image with allocated color.
		} break;
		case 'image/jpeg': {
			$im1 = imagecreatefromjpeg($filePath);
			$resizeMethod = 'imageCopyResampled';
		} break;
		case 'image/gif': {
			$im1 = imagecreatefromgif($filePath);
			#imagealphablending($im1, false);
			#imagesavealpha($im1, true);
			$resizeMethod = 'imageCopyResized';
			$transparent_index = imagecolortransparent($im1);
			if ($transparent_index != -1) { // If we have a transparent color
				$component = imagecolorsforindex($im1, $transparent_index); // Get the original image's transparent color's RGB values
				$transparent = imagecolorallocate($im2, $component['red'], $component['green'], $component['blue']); // Allocate the same color in the new image resource
				imagefill($im2, 0, 0, $transparent); // Completely fill the background of the new image with allocated color.
				imagecolortransparent($im2, $transparent); // Set the background color for new image to transparent
			}
		} break;
		default: return falsecho('Sorry, we\'re not resizing '.$info['mime'].' files');
	}

	# Вычисляем размеры картинки при ориганльном отношении сторон для искомых высоты и ширины
	$w = $w1*$h2/$h1;  //echo $w.'x100'.br;
	$h = $w2*$h1/$w1;  //echo '60x'.$h.br;

	$x = 0; $y = 0;
	if ($w > $w2) { # если найденная ширина больше необходимой, значит высотка совпала
		$h = $h2; //echo $w.'x'.$h2;
		$x = -floor(($w - $w2)/2); # центрируем картинку по ширине
	} else {
		$w = $w2; //echo $w2.'x'.$h;
		$y = -floor(($h - $h2)/2); # иначе центрируем по высоте
	}
#if($debug) hr($w.'x'.$h); //Ресайзнутая картинка

	# ресайзим по меньшей стороне и сдвигаем по большей
	$resizeMethod( //imageCopyResampled | imageCopyResized
		$im2,           # Ресурс целевого изображения.
		$im1,           # Ресурс исходного изображения.
		$x,             # x-координата результирующего изображения.
		$y,             # y-координата результирующего изображения.
		0,              # x-координата исходного изображения.
		0,              # y-координата исходного изображения.
		$w,             # Результирующая ширина.
		$h,             # Результирующая высота.
		$w1,            # Ширина исходного изображения.
		$h1             # Высота исходного изображения.
	);

	/** /if($debug){ //Выводим оригинальную и получившеюся картинки
	echo '<style type="text/css">IMG { border:2px solid red; }</style>';
	ob_start();
	switch($info['mime']){ case 'image/png': imagepng($im1); break; case 'image/jpeg': imagejpeg($im1); break; case 'image/gif': imagegif($im1); break; }
	$src1 = ob_get_contents(); ob_end_clean(); imagedestroy($im1);
	$i1 = new image(); $i1->src = 'data:image/png;base64,'.base64_encode($src1); echo $i1;
	ob_start();
	switch($info['mime']){ case 'image/png': imagepng($im2); break; case 'image/jpeg': imagejpeg($im2); break; case 'image/gif': imagegif($im2); break; }
	$src2 = ob_get_contents(); ob_end_clean(); imagedestroy($im2);
	$i2 = new image(); $i2->src = 'data:image/png;base64,'.base64_encode($src2); echo $i2;
	exit; }/**/

	create_dir(getkey('dirname', pathinfo($destPath)));
	switch($info['mime']){
		case 'image/png': imagepng($im2, $destPath); break;
		case 'image/jpeg': imagejpeg($im2, $destPath); break;
		case 'image/gif': imagegif($im2, $destPath); break;
	} imagedestroy($im2);

	return is_file($destPath)? $destPath : false;
}

# http://ru2.php.net/imagettfbbox#75491
/*   Функция imagettfbbox возвращает нам массив из восьми элементов,
     содержащий всевозможные координаты минимального прямоугольника,
     в который можно вписать данный текст. Индексы массива
     удобно обозначить на схеме в виде координат (x,y):

     (6,7)           (4,5)
       +---------------+
       |    text! :)   |
       +---------------+
     (0,1)           (2,3)

     Число элементов массива может на первый взгляд показаться избыточным,
     но не следует забывать о возможности вывода текста под произвольным
     углом.

     По этой схеме легко вычислить ширину и высоту текста:


$bbox = imagettfbbox(
    $this->size,    // размер шрифта
    0,              // угол наклона шрифта (0 = не наклоняем)
    $this->ttf,     // имя шрифта, а если точнее, ttf-файла
    $this->text     // собственно, текст
);
*/
function convertBoundingBox ($bbox) {
	if ($bbox[0] >= -1)
		$xOffset = -abs($bbox[0] + 1);
	else
		$xOffset = abs($bbox[0] + 2);
	$width = abs($bbox[2] - $bbox[0]);
	if ($bbox[0] < -1) $width = abs($bbox[2]) + abs($bbox[0]) - 1;
	$yOffset = abs($bbox[5] + 1);
	if ($bbox[5] >= -1) $yOffset = -$yOffset; // Fixed characters below the baseline.
	$height = abs($bbox[7]) - abs($bbox[1]);
	if ($bbox[3] > 0) $height = abs($bbox[7] - $bbox[1]) - 1;
	return array(
		'width' => $width,
		'height' => $height,
		'xOffset' => $xOffset, // Using xCoord + xOffset with imagettftext puts the left most pixel of the text at xCoord.
		'yOffset' => $yOffset, // Using yCoord + yOffset with imagettftext puts the top most pixel of the text at yCoord.
		'belowBasepoint' => max(0, $bbox[1])
	);
}

function showBoundingBox($bb, $text = false) {
	$lCoo = 11;                 # (±XXX,±XXX)
	$min = $lCoo + 3 + $lCoo;   # (±XXX,±XXX)___(±XXX,±XXX)

	$lLBP = 5; $LBP = str_repeat('_', $lLBP);   // Box Left Padding
	$LBPc = str_repeat('_', $lLBP+1);   // Box Left Padding in Center
	if (!$text) $text = 'text! ☺';
	$lLTP = 4; $LTP = str_repeat('_', $lLTP);   // Left Text Padding
	$lRTP = 4; $RTP = str_repeat('_', $lRTP);   // Right Text Padding

	$LT = str_pad('('.$bb[6].','.$bb[7].')', $lCoo, '_', STR_PAD_RIGHT);
	$RT = str_pad('('.$bb[4].','.$bb[5].')', $lCoo, '_', STR_PAD_RIGHT);
	$LB = str_pad('('.$bb[0].','.$bb[1].')', $lCoo, '_', STR_PAD_RIGHT);
	$RB = str_pad('('.$bb[2].','.$bb[3].')', $lCoo, '_', STR_PAD_RIGHT);

	//fo($LT, $RT, $LB, $RB); fo(strlen($LT), strlen($RT), strlen($LB), strlen($RB)); exit;

	///$lB = $lCoo + $lLTP + strlen($text) + $lRTP + $lCoo;
	$lB = $lLTP + strlen($text) + $lRTP; // box length
	$lTT = $lLBP + $lB + ceil($lCoo/2) + 2; // output length

	$box = $LT.str_repeat('_', $lTT-($lCoo*2)).$RT.br.
		$LBP.'+'.str_repeat('-', $lB-ceil($lCoo/2)+1).'+'.br.
		$LBPc.'|'. $LTP . $text . $RTP.'|'.br.
		$LBP.'+'.str_repeat('-', $lB-ceil($lCoo/2)+1).'+'.br.
		$LB.str_repeat('_', $lTT-($lCoo*2)).$RB
	;

	/*
		$box = ''.
	   ''.$LT.'        '.$RT.br
	   ._._.'+---------------+'.br
	   ._._.'|    text! ☺    |'.br
	   ._._.'+---------------+'.br
	   .$LB.'        '.$RB.br;
	*/

	//$LT = str_replace('_', _, $LT); $RT = str_replace('_', _, $RT); $LB = str_replace('_', _, $LB); $RB = str_replace('_', _, $RB);
	$box = str_replace('_', _, $box);

	echo $box;

}


// CLASS: PIC  #004
    #ini_set("memory_limit", "1500M");
#$pic = pic($path); echo $pic->img('border:1px solid red').br; fox($pic->about());
function pic() {
	$reflector = new ReflectionClass('pic');
	return $reflector->newInstanceArgs(func_get_args());
}
function ispic($obj){ return ($obj instanceof pic); }
class pic {
# http://www.php.net/manual/ru/ref.image.php
# http://www.php.net/manual/ru/intro.image.php
# http://php.net/manual/ru/language.operators.bitwise.php
# http://www.php.net/manual/ru/function.imagecolorat.php
# http://www.php.net/manual/ru/function.imagecolorset.php
# http://www.php.net/manual/ru/function.imagecolorsforindex.php
# https://github.com/h4ck3rm1k3/hiphop-php/blob/2c502b2457b4a72a56c96c7908f46cbe37a8d4db/phpt/tests/php-5.2.5/ext/gd/tests/bug24594.phpt
# http://www.php.net/manual/ru/function.imagecreatefrompng.php
# http://php.net/manual/en/function.imagesetpixel.php
# Треугольник Серпинского # http://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%B5%D1%83%D0%B3%D0%BE%D0%BB%D1%8C%D0%BD%D0%B8%D0%BA_%D0%A1%D0%B5%D1%80%D0%BF%D0%B8%D0%BD%D1%81%D0%BA%D0%BE%D0%B3%D0%BE

# .xpm
# http://upload.wikimedia.org/wikipedia/commons/f/fd/Incorrect_8bits_palette_sample_image.png?uselang=ru

# http://stackoverflow.com/questions/5702953/imagecolorat-and-transparency
# http://stackoverflow.com/questions/5495275/how-to-check-if-an-image-has-transparency-using-gd
	var $state = 'ready';
	# 'off' — не готов для работы
	var $changed = false;
	var $resource; //Хранилище для GD-Идентификатора на текущее изображение, получать функцией $this->getim();

	function __construct($dano, $type=false) {
		$this->mem = o('onStart', memory_get_usage());
		if (is_string($dano)) $this->setByPath($dano);
		elseif ($this->isGD($dano)) $this->setByGD($dano, $type);
		//$this->getim(); #?
		return $this;
	}

	/** Построенние внутреннего Объекта по Пути*/
	function setByPath($filePath) {
		$this->updPath($filePath);
		if (!is_file($this->path)) $this->state = 'off';
		else $this->buildInfo($this->path);
	}
	/** Построенние внутреннего Объекта по GD-идентификатору*/
	function setByGD($GDResource, $type) {
		$this->type = $type;
		$this->resource = $GDResource;
		$this->buildInfo($GDResource, set('genName'));
	}
	/** Установка параметров для последующей операции*/
	var $set; //переменная временных установок
	function set() { list($N, $A) = array(func_num_args(), func_get_args());
		$this->set = ($N==1)? new o($A[0]) : o()->upd($args = func_get_args());
		return $this;
	}
	function clearSet() { $this->set = o(); return $this; }

	/** Добавление результатов операции в стек событий */
	var $res = array(); //Информация о сохранённых результатах операций с картинкой
	function res($RecName, $RecData) {
		if (!isset($this->res[$RecName])) $this->res[$RecName] = $RecData;
		elseif (is_array($this->res[$RecName])) array_push($this->res[$RecName], $RecData);
		else $this->res[$RecName] = array($this->res[$RecName], $RecData);
	}

	function __get($prop) {
		if ($prop=='im') return $this->getim();
	}
	/** Проверяет является ли объектом Идентификатором на GD-Изображение */
	function isGD($obj){ return (is_resource($obj)&&get_resource_type($obj)=='gd'); }

	/** Добавляет информацию о пути */
	function updPath($path){
		$this->path = $path;
		$this->name = pathinfo($path, PATHINFO_FILENAME);
		return $this;
	}

	/** Получение таких данных о картинке, как:
	->w - ширина
	->h - высота
	->b - размер в байтах
	->bpp - byte per pixel - глубина цвета
	->type - тип картинки
	->ext - расширение файла
	->mime - MIME тип
	->phpImageFlag - image-type for image_type_to_mime_type
	 */ #003
//php://memory/resource=img.jpeg
	function buildInfo($ImgRes, $set=false) { $set = set($set);
		if ($this->isGD($ImgRes)) {
			$isGD = true; $ImgRes = $this->src($ImgRes, false);
			if ($set->genName) $this->name = hash('adler32', $ImgRes);
		} elseif (is_file($ImgRes)) $isGD = false; else return;
		$info = $isGD? GisFromString::getImageSize($ImgRes) : getimagesize($ImgRes);
		if ($info) {
			list($this->w, $this->h, $this->phpImageFlag) = $info;
			$this->bpp = $info['bits']; # byte per pixel
			$this->mime = $info['mime'];
			list(,$this->type) = explode('/', $this->mime);
			$this->b = $isGD? strlen($ImgRes) : filesize($ImgRes);

			$this->ext = '.'.$this->type;
			$this->code = $this->sysname();
		}
		return $this;
	}

	/** Выводит общую информацию о картинке
	 */ #002
	function about(){ $info = o();
		foreach (array('path', 'name', 'type', 'ext', 'code', 'w', 'h', 'b', 'bpp') as $prop) {
			switch ($prop) {
				case 'b': $name = 'размер'; break;
				default: $name = $prop;
			}
			$info->$name = $this->$prop;
		} return $info;
	}
	/** Возвращает массив указанных данных
	 *удобно использовать для list($w, $h, $type) = $pic->data('w','h','type'); */
	function data() {
		if (func_num_args()==0) {
			$needs = o();
			foreach($this as $prop=>$data) $needs->$prop = $data;
		} else {
			$needs = array();
			foreach (func_get_args() as $n=>$prop) $needs[$n] = $this->$prop;
		}
		return $needs;
	}

	/** Генерирует уникальной имя, использую Хеш Adler32
	 */ #001
	function sysname() {
		list($w, $h, $size, $name) = $this->data('w', 'h', 'b', 'name');
		$code = hash('adler32', $w.'x'.$h.'['.$size.']~'.$name); //super unique ~ notch();
		return $code;
	}
	/** Получить Идентификатор текущего Изображения
	 */
//$resourceData=false @param Если указан $resourceData - вернёт полную
	function getim(){
		if(is_resource($this->resource)) return $this->resource;
		elseif (is_file($this->path)) switch($this->type){
			case 'png': return $this->resource = $this->getPNG();
			case 'gif': return $this->resource = $this->getGIF();
			case 'jpg': case 'jpeg': return $this->resource = $this->getJPG();
			default: return undefined;
		} else return false;
	}
	/** Освободить Идентификатор Изображения $this->im*/
	function delim() {
		qlog('Q:px:Удаление Ресурса размером ['.calc_size($this->b).'] использовали ['.calc_size($mm=(memory_get_usage()-$this->mem->onStart)).'] это примерно ['.calc_size(ceil($mm/($this->w*$this->h))).'] на 1 пиксель');
		if (is_resource($this->resource)&&get_resource_type($this->resource)=='gd')
			imagedestroy($this->resource);
	}

	/** Составляет уникальный путь до нового файла
	 */ #005
	function new_path($set = false) {
		$set = set($set);
		$dir = $set->value('dir', dirname($this->path)); //g('user')->dir.'tmp'
		if($set->subdir) $dir = rtrim($dir,'\/').l.$set->subdir;
		if ($set->fname=='auto') $fname = hash('adler32',notch());
		elseif ($set->fname=='bycode') $fname = $this->code;
		else $fname = $set->value('fname', $this->name);
		$type = $set->value('type', $this->type);
		$name = $set->value('name', $fname.'.'.$type);
		$path = $set->value('path', rtrim($dir,'\/').l.$name);
		//fox($set, $dir, $fname, $type, $name, $path);
		return $set->rewrite? $path
			: filename($path!==$this->path? $path
				: $this->new_path($set->upd('fname', $this->name.'[rw]'))
			)
		;
	}

	/** Переименовывает исходный фаил с учётом установок $set
	@version 001 */
	function rename($set = false) { $this->changed = false;
		$set = setargs(func_get_args());
		$path = $this->new_path($set);
		$this->changed = !!@rename($this->path, $path); #Переименовывание картинки
		if ($this->changed) $this->updPath($path);
		if ($set->re) {
			if($set->re=='state') return $this->changed;
			if($set->re=='path') return $path;
		} return $this;
	}

	/** Сохраняет Текущее изображение если не указан $dest, то перезаписывает себя
	И удаляет ресурс, если не указно обратное
	 */ #004
	function save($set = false) {
		//$set = set($set)->def('clear',f); //fox($set);
		$set = setargs(func_get_args())->def('clear',f); //fox($set);
		$path = $this->new_path($set); //fox($path);
		//fox($this->path, $path, $set); //hr('SAVE2: '.$path); return $this;
		$resource = $set->value('im', $this->getim());
		create_dir(dirname($path));
		$this->changed = !!@$this->image($resource, $path); #Сохранение картинки;
		if($set->clear) $this->delim();
		if(!$set->{'!upd'}) {
			if($set->rewrite && $this->path !== $path) unlink($this->path);
			$this->updPath($path);
		}

		if ($set->re) {
			if($set->re=='state') return $this->changed;
			if($set->re=='im') return $resource;
			if($set->re=='path') return $path;
			if($set->re=='newpic') return pic($resource, $this->type)->updPath($this->new_path());
		} return $this;
	}
	/** Выводит Изображение в браузер или пишет в файл
	allias для imagepng || imagejpeg || imagegif в зависимости типа */
	function image() { $args = func_get_args();
		switch($this->type){
			#PNG: resource $image [, string $filename [, int $quality [, int $filters ]]]
			case 'png': $funca = 'imagepng'; break;
			#JPG: resource $image [, string $filename [, int $quality ]] )
			case 'jpeg': case 'jpg': $funca = 'imagejpeg'; break;
			#GIF: bool imagegif ( resource $image [, string $filename ] )
			#формат GIF87a, или формат GIF89a, если изображение было сделано прозрачной функцией imagecolortransparent()
			case 'gif': $funca = 'imagegif'; break;
			# bool imagegd ( resource $image [, string $filename ] )
			default: $funca = 'imagegd';
		}
		return call_user_func_array($funca, $args);
	}
	/** Allias для PHP-функций imageCopyResampled | imageCopyResized, в зависимости от типа изображения */
// для GIF вызывается imageCopyResized, иначе терятеся качество картинки (в частности непраивльно обрабатываются прозрачные пиксели)
	function phpResize() { $args = func_get_args();
		$resizeMethod = $this->type=='gif'? 'imageCopyResized' : 'imageCopyResampled';
		call_user_func_array($resizeMethod, $args);
	}
	/** Возвращает содержимое Изображения
	@param Идентификатор Изображения
	@param Сохранять ли результат для текущей картинки
	 */
	function src($resource = undefined, $saveResult = true) {
		$notSelfIm = undef($resource); $im = undef($resource, $this->getim());
		ob_start(); //http://us3.php.net/manual/ru/book.outcontrol.php
		$this->image($im);
		$res = ob_get_clean();
		ob_end_clean(); //ob_end_flush();
		if ($saveResult) $this->src = $res;
		return $res;
	}

	/** Allias для imagecreatetruecolor
	 * так же можно указать дополнительные настройки через set()
	 * для png и gif изображение будетпрозрачным если не указано обртаное
	 */
//$im2 = $this->newImage(100,100,f); echo $this->img('border:1px solid lime',$im2); exit;
	function newImage($w, $h, $isTransparent = undefined) {
		$im_ = imagecreatetruecolor($w, $h);
		if (in_array($type=$this->type, array('png','gif'))&&$isTransparent) {
			imagealphablending($im_, false);
			imagesavealpha($im_, true);
			$transparent = imagecolorallocatealpha($im_, 255, 255, 255, 127);
			imagefill($im_, 0, 0, $transparent);
			imagecolortransparent($im_, $transparent);
		}
		return $im_;
	}

	/** Получить Идентификатор Изображения из PNG-файла*/
	function getPNG($path=undefined){ undef($path, $this->path);
		$png = imagecreatefrompng($path);
		imagealphablending($png, false); //false = дабы использовать только собственныое значение альфы, +нужен для imagesavealpha
		imagesavealpha($png, true); //сохранять всю информацию альфа компонента (в противовес одноцветной прозрачности)
		return $png;
	}

	/** Получить Идентификатор Изображения из JPG-файла*/
	function getJPG($path=undefined){ undef($path, $this->path);
		$jpg = imagecreatefromjpeg($path);
		return $jpg;
	}

	/** Получить Идентификатор Изображения из GIF-файла*/
	function getGIF($path=undefined){ undef($path, $this->path);
		$gif = imagecreatefromgif($path);
		$transparent_index = imagecolortransparent($gif); //Если второй-аргумент $color не задан и в изображении нет прозрачных цветов, фунция вернет -1.
		if ($transparent_index != -1) { //Дальше пока непонятная магия ☺
			$component = imagecolorsforindex($gif, $transparent_index); // Get the original image's transparent color's RGB values
			$transparent = imagecolorallocate($gif, $component['red'], $component['green'], $component['blue']); // Allocate the same color in the new image resource
			imagefill($gif, 0, 0, $transparent); // Completely fill the background of the new image with allocated color.
			imagecolortransparent($gif, $transparent); // Set the background color for new image to transparent
		}
		return $gif;
	}

	/** Выполняет ресайз картинки по заданым установккам
	@param Размер требуемого Изображения, варианты: 100x100 | ~600x~600 | ~600x~ | ~x~
	@param Можно указать данные другого изображения o(resource, w, h)
	 */
	function resize($size) { //011
		$set = setargs(func_get_args(),1);
		$PIC = ispic($set->pic)? $set->pic : $this;

		$ref = $PIC->getim();
		list($w1, $h1) = $PIC->data('w', 'h');

		list($w2, $h2) = is_string($size)? explode('x', strtolower($size)) : $size;
		list($isP, $isL) = array(($w2<$h2), ($w2>$h2)); //isPortrait, isLandsscape
		if( #modified Sized - если в параметре присуствует знак тильды ~
			($wm = ($w2[0]=='~')?(strlen($w2)==1?true:substr($w2, 1)):false) //modified Width
			+ ($hm = ($h2[0]=='~')?(strlen($h2)==1?true:substr($h2, 1)):false) //modified Height
			+ ($code = var2dstr($wm).var2dstr($hm))
		){ #тогда размеры вычисляем на их основе
			switch($code) {
				case '11': $DoNotResize=t; break; # ~ x ~
				case '01': { # D x ~
					$h2 = round($h1*$w2/$w1);
				} break;
				case '10': { # ~ x D
					$w2 = round($w1*$h2/$h1);
				} break;
				case '12': { # ~ x ~D
					$h2 = ($h1>$hm)? $hm : $h1;
					$w2 = round($w1*$h2/$h1);
				} break;
				case '21': { # ~D x ~
					$w2 = ($w1<$wm)? $w1 : $wm;
					$h2 = round($h1*$w2/$w1);
				} break;
				case '20': { # ~D x D
					$w2 = round($w1*$h2/$h1);
					if ($w2 > $wm) { $w2 = $wm;
						$h2 = round($w1*$w2/$h1);
					}
				} break;
				case '02': { # D x ~D
					$h2 = round($w1*$w2/$h1);
					if ($h2 > $hm) { $h2 = $hm;
						$w2 = round($w1*$h2/$h1);
					}
				} break;
				case '22': { # ~D x ~D
					$w2 = ($wc=($w1>$wm))? $wm : $w1;
					$h2 = ($hc=($h1>$hm))? $hm : $h1;
					if ($wc&&$hc){
						$ht = round($h1*$w2/$w1);
						$wt = round($w1*$h2/$h1);
						if ($wt <= $wm) $w2 = $wt; else $h2 = $ht;
					}
					elseif($wc) $h2 = round($h1*$w2/$w1);
					elseif($hc) $w2 = round($w1*$h2/$h1);
					else $DoNotResize=t; //оставляем без изменения
					/*
					$sW = $img->w > 1600? '1600x~' : false;
					$sH = $img->h < 1200? '~x1200' : false;
					if ($sW||$sH) { //Нужен ли ресайз
						$r3size = $img->isPortrait? ($sH?$sH:$sW) : ($sW?$sW:$sH); //Если картинки портетная, то сначала проеверяем высоту, если например картинка большая по обоим параметрам, то она может направильно сресаёзится, если не проверять на её ориентированность (Портератная или Панорамная)
						$r3 = resize($img->original, $img->view, $r3size);
					} $r3 = copy_file($img->original, $img->view);
					*/
				} break;
			}
		} #else работает с заданными величинами
		if (!@$DoNotResize) {
			# Вычисляем размеры картинки при ориганльном отношении сторон для искомых высоты и ширины
			$w = $w1*$h2/$h1;
			$h = $w2*$h1/$w1;
			$x = 0; $y = 0;
			if ($w > $w2) { # если найденная ширина больше необходимой, значит высотка совпала
				$h = $h2; //echo $w.'x'.$h2;
				$x = -floor(($w - $w2)/2); # центрируем картинку по ширине
			} else {
				$w = $w2; //echo $w2.'x'.$h;
				$y = -floor(($h - $h2)/2); # иначе центрируем по высоте
			}
			$res = $this->newImage($w2, $h2);

			# ресайзим по меньшей стороне и сдвигаем по большей
			$this->phpResize( //imageCopyResampled | imageCopyResized
				$res,           # Ресурс целевого изображения.
				$ref,           # Ресурс исходного изображения.
				$x,             # x-координата результирующего изображения.
				$y,             # y-координата результирующего изображения.
				0,              # x-координата исходного изображения.
				0,              # y-координата исходного изображения.
				$w,             # Результирующая ширина.
				$h,             # Результирующая высота.
				$w1,            # Ширина исходного изображения.
				$h1             # Высота исходного изображения.
			);
		} else $res = $ref;

		if($set->{'!upd'}) {
			if ($set->save) {
				$saveSet = $set->save; $saveSet->im = $res;
				return $this->save($saveSet);
			}
			if($set->has('re','newpic')) return pic($res, $this->type)->updPath($this->new_path());
		} elseif (!@$DoNotResize) {
			$this->buildInfo($res);
			$this->resource = $res;
			$this->changed = true;
			$this->state = 'resized';
		}
		//$this->res('resize', o('w',$w1, 'h',$h1, 'W',$w, 'H',$h));
		return $this;
	}

	/** Получение сводной информации об пикселе по координатам*/
	function pixelInfo($x, $y, $resource=undefined) {
		$im = undef($resource, $this->getim());
		$px = o('x',$x, 'y',$y);
		$px->index->dec = imagecolorat($im, $x, $y);
		$px->index->hex = base_convert($px->index->dec, 10, 16);
		$px->index->bin = base_convert($px->index->dec, 10, 2);
		$px->put(imagecolorsforindex($im, $px->index->dec)); //red, green, blue, aplha
		$px->isTransparent = $px->alpha==127;
		$px->hasAlpha = $px->alpha!==0;
		$px->color->val = str_pad(substr($px->index->hex, -6), 6, '0', STR_PAD_LEFT);  //$px->index->dec===0? '000000' : substr($px->index->hex, -6);
		$px->color->{'='} = '#'.$px->color->val;
		$px->opacity = !$px->isAlpha? 1 : 1-round($px->alpha/127,2);
		//qlog('Q:px: '.$x.$y.'+');
		return $px;
	}

	function isLineTransparent($lineN, $lineIsHorisontal = true, $resource = undefined) {
		$im = undef($resource, $this->getim());
		$set = array($im);
		if ($lineIsHorisontal) {
			$lim = $this->w; $pos = 1;
			array_push($set, 0, $lineN);
		} else {
			$lim = $this->h; $pos = 2;
			array_push($set, $lineN, 0);
		}
		for ($px = 0; $px < $lim; $px++) {
			$set[$pos] = $px;
			$dec = call_user_func_array('imagecolorat', $set);
			$ci = imagecolorsforindex($im, $dec); # Color Info
			if ($ci['alpha'] < 127) return 0;
		} return 1;
	}

//Кропит текущую картинку от прозрачных краёв
	function cropTransparent() { $set = setargs(func_get_args());
		if ($this->state == 'off') return;
		$xy = o('T',0, 'R',0, 'B',0, 'L',0); # Угловые Координаты прямогульника куда вписано изображение
		$Y = 0; while ($this->isLineTransparent($Y)){ ++$Y; $xy->T++;
			if($Y==($this->h-1)){ $this->im = imagecreatetruecolor(1,1); return $this; }} //значит картинка была полностью прозрачна
		$Y = $this->h - 1; while ($this->isLineTransparent($Y)){ --$Y; $xy->B++; }
		$X = 0; while ($this->isLineTransparent($X, false)){ ++$X; $xy->L++; }
		$X = $this->w - 1; while ($this->isLineTransparent($X, false)){ --$X; $xy->R++; }

		$w = $this->w - $xy->L - $xy->R;
		$h = $this->h - $xy->T - $xy->B;
		$res = $this->newImage($w, $h);
		imagecopy(
			$res,
			$this->getim(),
			0, 0,
			$xy->L, $xy->T,
			$this->w, $this->h
		); //echo $this->img('border:1px solid lime',$res);

		if($set->newpic) {
			$newpic = new pic($res, $this->type);
			if ($set->save) {
				$saveSet = $set->save; $saveSet->im = $res; $saveSet->re = 'path';
				$newPath = $this->save($saveSet);
				$newpic->updPath($newPath);
			}
			return $newpic;
		} else {
			$this->buildInfo($res);
			$this->resource = $res;
			$this->changed = true;
			$this->state = 'croped';
			return $this;
		}

		//$this->res('AutoTCrop', o('xy',$xy, 'v',$this->w-$w, 'h',$this->h-h));

	}

	/** Поучение bitmap`а картинки*/
//function map($resource) { $im = undef($resource, $this->getim());
	function map() {
		#qlog('Q:px:map-start');
		$im = $this->getim();
		$map = array();
		$X = $this->w; $Y = $this->h;
		for($y = 0; $y < $Y; $y++) {
			$map[$y] = array(); //rows
			for($x = 0; $x < $X; $x++) {
				$map[$y][$x] = $this->pixelInfo($x, $y);
			}
		}
		$this->delim();
		#qlog('Q:px:map-finish');
		return $map;
	}

	function map4jspic() {
		$data = array();
		$map = $this->map();
		foreach ($map as $j=>$row) {
			$data[$j] = array();
			foreach ($row as $i=>$px) {
				$data[$j][$i] = $c = o('y',$j, 'x',$i);
				if ($px->hasAlpha) {
					if ($px->alpha == 127) $px->color->{'='} = 'none';
					else $c->o = $px->opacity;
				}
				$c->c = $px->color->{'='};
			}
		}
		return $data;
	}

	function img($css = false, $resource = undefined) {
		return '<img'.($css?' style="'.$css.'"':'').' src="data:image/png;base64,'.base64_encode($this->src($resource)).'" alt="pic:'.$this->name.'" />';
	}

} //-- pic

/*
#------------------------------------------#
$path = 'C:\Users\zap\Desktop\\'.'pic.png';
$pic = pic($path);
echo $pic->img('border:1px solid lime');
$tpic = $pic->cropTransparent();
$tpic = $pic->cropTransparent('newpic');
$tpic->resize('~x304');
echo $tpic->img('border:1px solid green');
echo $pic->img('border:1px solid aqua');
exit;  #-----------------------------------#
$dir = 'C:\Users\zap\Desktop\tt\\';
$pic = pic($path)->cropTransparent()
    ->resize('~x304',set('!upd', o('save', set('!upd', 'dir:'.$dir, 'fname:auto'))))
    ->resize('~x205',set('!upd', o('save', set('!upd', 'dir:'.$dir, 'fname:auto'))))
; exit;  #---------------------------------#
$dir = 'C:\Users\zap\Desktop\tt\\';
$src = pic($path)->cropTransparent('newpic');
echo $src->resize('~x304', '!upd', o('save', set('!upd', 'dir:'.$dir, 'fname:auto', 're:newpic')))->img('border:1px solid red');
echo $src->resize('~x204', '!upd', o('save', set('!upd', 'dir:'.$dir, 'fname:auto', 're:newpic')))->img('border:1px solid green');
echo $src->img('border:1px solid blue');
; exit;  #---------------------------------#
*/


/** @author http://stackoverflow.com/users/26258/fireweasel */
function image_file_type_from_binary($binary) {
	if (!preg_match('/\A(?:(\xff\xd8\xff)|(GIF8[79]a)|(\x89PNG\x0d\x0a)|(BM)|(\x49\x49(?:\x2a\x00|\x00\x4a))|(FORM.{4}ILBM))/', $binary, $hits)) {
		return 'application/octet-stream';
	}
	static $type = array (
		1 => 'image/jpeg',
		2 => 'image/gif',
		3 => 'image/png',
		4 => 'image/x-windows-bmp',
		5 => 'image/tiff',
		6 => 'image/x-ilbm',
	);
	return $type[count($hits) - 1];
}
// getimagesize() from string
/* #usage:
$imgdata = file_get_contents('path/lenna.jpg');
GisFromString::register('other'); //if the default protocol is already registered
var_dump(GisFromString::getImageSize($res));
echo GisFromString::getMimeType($res);
*/
class GisFromString {
	const proto_default = 'gisfromstring';
	protected static $proto = null;
	protected static $imgdata = null;
	static function getImageSize($imgdata) {
		if (null === self::$proto) self::register();
		self::$imgdata = $imgdata;
		// note: @ suppresses "Read error!" notices if $imgdata isn't valid
		return @getimagesize(self::$proto . '://');
	}
	static function getMimeType($imgdata) {
		return is_array($gis = self::getImageSize($imgdata))? $gis['mime'] : $gis;
	}
// streamwrapper helper:
	const unregister = null;
// register|unregister wrapper for the given protocol|scheme
// return registered protocol or null
	static function register($proto = self::proto_default /*protocol or scheme*/) {
		if (self::unregister === $proto) { // unregister if possible
			if (null === self::$proto) return null;
			if (!stream_wrapper_unregister(self::$proto)) return null;
			return $return = self::$proto = null;
		}
		if (!preg_match('/\A([a-zA-Z][a-zA-Z0-9.+\-]*)(:([\/\x5c]{0,3}))?/', $proto, $h))
			throw new Exception(sprintf('could not register invalid scheme or protocol name "%s" as streamwrapper', $proto));
		if (!stream_wrapper_register($proto = $h[1], __CLASS__))
			throw new Exception(sprintf('protocol "%s" already registered as streamwrapper', $proto));
		return self::$proto = $proto;
	}
// streamwrapper API:
	function stream_open($path, $mode) {
		$this->str = (string) self::$imgdata;
		$this->fsize = strlen($this->str);
		$this->fpos = 0;
		return true;
	}
	function stream_close(){ self::$imgdata = null; }
	function stream_read($num_bytes) {
		if (!is_numeric($num_bytes) || $num_bytes < 1) return false;
		/* uncomment this if needed
		if ($this->fpos + $num_bytes > 65540 * 4) {
			// prevent getimagesize() from scanning the whole file
			// 65_540 is the maximum possible bytesize of a JPEG segment
			return false;
		}
		*/
		if ($this->fpos + $num_bytes > $this->fsize) {
			$num_bytes = $this->fsize - $this->fpos;
		}
		$read = substr($this->str, $this->fpos, $num_bytes);
		$this->fpos += strlen($read);
		return $read;
	}
	function stream_eof(){ return $this->fpos >= $this->fsize; }
	function stream_tell(){ return $this->fpos; }
	function stream_seek($off, $whence = SEEK_SET) {
		if (SEEK_CUR === $whence) $off = $this->fpos + $off;
		elseif (SEEK_END === $whence) $off = $this->fsize + $off;
		if ($off < 0 || $off > $this->fsize) return false;
		$this->fpos = $off;
		return true;
	}
} //--GisFromString


