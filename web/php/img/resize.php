<?#1.4.1

_needphp(
	'set',
	'isAssoc',
	'img/fn',
	'img/gd',
	'file'//, //'file/unique_path'
	//'t'
);

/*
    oo
        web/test/php/img/resize/index1.php

    eg
        i_resize($path, [100, 100])
        i_resize($path, 'h200')
        i_resize([
            path
            width
            height
        ], [
            path
            width
            height
            dir
            subDir
            name
        ], [
            replace - если имя нового файла уже имеется: заменять его или переименовывать
            clean - удаление gd-ресурса после операции

            baseDir
            subDir
            dir
            name
            x1 y1 w1 h1 - область выделения на исходнике
            x2 y2 w2 h2 - область переноса на резудьтате

            getInfo - верунть данные нового файлаб
            getGd - верунть gd-ресурс
            getObj - верунть используемый для ресайза объект gdImage

            resize - флаг начала ресайза
        ])

        i_resize($imgPath, array(200, 200), array(
            'saveSubDir' => 'tt',
            //берем исходник (700x700) в значениях:
                'x1' => 100, 'y1' => 100,
                'w1' => 600, 'h1' => 600,
            //и помещаем на холст (200x200) в значения:
                'x2' => 50, 'y2' => 50,
                'w2' => 100, 'h2' => 100,
        ));
*/

/*

$srcConf
		[s] = path
    path
		| gd
    ?width
    ?height
$resConf
		[s] = sizeName (eg: '200x100')
		[n] = sizeName (квадратный: eg: 100 ~ '100x100')
		[ao] = sizeName ([200, 100])
    path
		| rl $resConf[path]
		| rl $set->baseDir / $set->subDir / $set->name / $set->type
		| rl $set->resPath
    width
    height


$opts = set

	clean - удаление рабочего gd-ресурса
		удаление gd-ресурса после операции

    resize - флаг начала ресайза / фдаг длля остановки ресайза
		при false - не будет выполняться resize

    replace - если имя нового файла уже имеется: заменять его или переименовывать

    stretch - настройки размещения картинки до требуемого формата
		'fit'

	resPath - указание через опцию $resConf['path'], потому как resPath, часто используется просто как 〈[s] = sizeName〉
	baseDir / subDir / name / type - для определения resPath (пути сохранения resiz'нутой картинки)

	x1 / y1 / w1 / h1 - область выделения на исходнике
	x2 / y2 / w2 / h2 - область переноса на резудьтате

	getInfo - верунть данные нового файла
	getGd - верунть gd-ресурс
	getObj - верунть используемый для ресайза объект gdImage
*/
function i_resize($srcConf, $resConf, $opts = false){
	$set = set(array(
        'clean' => true,
        'resize' => true,
        'replace' => false,
        //'stretch' => false,
        //'getInfo' => false,

	), $opts);
    //dx($srcConf, $resConf, $set->options);

    //step: прием данных
	if (is_string($srcConf)) {
		$srcConf = array('path' => $srcConf);
	}
	if (!isset($srcConf['width'])) {
        //if (isset($srcConf['path']))
		list($srcConf['width'], $srcConf['height']) = getimagesize($srcConf['path']);
	}

	if (is_string($resConf)) { //case: '100x100' = array(100, 100)
		$sizeName = $resConf;
		$resConf = i_resize_fn::calcResize($srcConf, $sizeName); //={ao[width, height]}
		//$resConf = array('size' => $resConf);
	}
	if (is_numeric($resConf)) { //case: 100 = array(100, 100)
        //$resSize = $resConf;
        $resConf = array($resConf, $resConf);
    }
    if (isOrdinal($resConf)) { //case: array(100, 100) = = array('width' => 100, 'height' => 100)
        //$resSize = $resConf;
		$resConf = array('width' => $resConf[0], 'height' => $resConf[1]);
	}


	if (!isset($resConf['path']) && $set->resPath) {
		$resConf['path'] = $set->resPath;
	}


	if (!isset($resConf['path'])) {
		//step: вычисление пути для сохранения файла
        $srcPath = prop($srcConf, 'path');



        $resDir = prop($resConf, 'dir', $set->dir);
        if (!$resDir) {
            $baseDir = prop($resConf, 'baseDir', $set->baseDir);
            if (!$baseDir) {
                $baseDir = $srcPath ? dirname($srcPath) : WEB.'/tmp';
            }

            if (!isset($sizeName)) $sizeName = $srcConf['width'].'x'.$srcConf['height'];
            $subDir = prop($resConf, 'subDir', $set->opt('subDir', $sizeName));

            $resDir = $baseDir.($subDir ? '/'.$subDir : '');
        }

		dx($resDir, $srcConf, $resConf);

		if (!is_dir($resDir)) mkdir($resDir, 0755, true);

        $resName = prop($resConf, 'name', $set->name);
        if (!$resName) {
            if ($srcPath){
                $resName = basename($srcPath);
            } else {
                _needphp('t');
                $resName = time().udate('u');
                if ($type = prop($srcConf, 'type', $set->type)) {
                    $resName .= ".$type";
                }
            }
        }

		$resConf['path'] = $resDir.'/'.$resName;
	}
	if (!$set->replace) {
		$resConf['path'] = unique_path($resConf['path']);
	}

    //dbg: возмжность переопределить входящие данные
    if ('dbg') {
        if (!1) {
            $resConf['width'] = 200;
            $resConf['height'] = 300;
            $set->setData(array(
                //берем исходник в значении (700x700)
                'x0' => 0,
                'y0' => 0,
                'w0' => 700,
                'h0' => 700,
                //и помещаем на холст в значения
                'x2' => 50,
                'y2' => 50,
                'w2' => 300,
                'h2' => 200,
            ));
        }

        if (!1) {
            //$set->stretch = true;
        }
    }

    //step: процесс ресемплирования картинок
    $set->setDefaults(array(
        //берем исходник в значении
        'x1' => 0,
        'y1' => 0,
        'w1' => $srcConf['width'],
        'h1' => $srcConf['height'],
        //и помещаем на холст в значения
        'x2' => 0,
        'y2' => 0,
        'w2' => $resConf['width'],
        'h2' => $resConf['height'],
        //для получения картинки
        'w' => $resConf['width'],
        'h' => $resConf['height']
    ), true);

    //d($srcConf, $resConf, $set->info());

    //dd[#1]
    //dx($set->stretch, $set->options);
    if ($set->hasOpt('stretch')) {
        i_resize_fn::set_stretch($set->stretch, $set);
    }

    //dx($set->resize, $set->options);
    if ($set->resize) {

        if (isset($srcConf['gd'])) {
            $gdSrc = $srcConf['gd'] instanceof gdImage ? $srcConf['gd'] : i_gd($srcConf);
        } else {
            $gdSrc = i_gd($srcConf['path']);
        }

        $gdRes = i_gd(array(
            'width' => $set->w,
            'height' => $set->h,
            'type' => $gdSrc->type,
        ));

        //d($gdSrc, $gdRes, $set->options);

        imagecopyresampled(
            $gdRes->image,  # Ресурс целевого изображения.
            $gdSrc->image,  # Ресурс исходного изображения.
            $set->x2,       # x-координата результирующего изображения.
            $set->y2,       # y-координата результирующего изображения.
            $set->x1,       # x-координата исходного изображения.
            $set->y1,       # y-координата исходного изображения.
            $set->w2,       # Результирующая ширина.
            $set->h2,       # Результирующая высота.
            $set->w1,       # Ширина исходного изображения.
            $set->h1        # Высота исходного изображения.
        );

        if ($set->getObj) { //0
            $gdRes->save($resConf['path'], $set->clean);
            return $gdRes;
        }

        if ($set->getGd) { //0
            $gdRes->save($resConf['path'], false);
            return $gdRes->image;
        }

        $gdRes->save($resConf['path']);

        if ($set->getInfo) {
            return array(
                'path' => $gdRes->pathSaved, //$resConf['path']
                'width' => $set->w,
                'height' => $set->h,
                'type' => $gdRes->type
            );
        }

        return $resConf['path'];
    }


	return false;
}

//вспомогательные функции для работы resize
class i_resize_fn {

    /*
        использумеые форматы
        h100
        w200
        300x100
    */
    //i_calcResize
    static function calcResize($sizesData, $szCode){
        $res = null;
        $w = $h = null;
        if (is_string($szCode)){
            list($w0, $h0) = image_fn::formatSize($sizesData, 0);
            $r = $w0 / $h0;

            if (!$res) {
                //step: rel-size
                $rega = '~^(\w)(\d+)$~'; //https://regex101.com/r/GZ6etq/1/
                if (preg_match($rega, $szCode, $matches)) {
                    if ($matches[1] == 'w') {
                        $w = $matches[2];
                        $h = floor($w / $r);
                    } else if ($matches[1] == 'h') {
                        $h = $matches[2];
                        $w = floor($h * $r);
                    }
                    $res = array('width' => (integer) $w, 'height' => (integer) $h);
                };
            }

            if (!$res) {
                //step: straight-size
                $rega = '~^(\d+)x(\d+)$~'; //https://regex101.com/r/pXPmtH/2/
                if (preg_match($rega, $szCode, $matches)) {
                    $res = array(
                        'width' => (integer) $matches[1],
                        'height' => (integer) $matches[2]
                    );
                };
            }

        }
        return $res;
    }


    static function set_stretch($val, &$set){
        $willStretch = $set->w1 < $set->w2 || $set->h1 < $set->h2;
        //dx($willStretch, $set->options);
        if ($willStretch) {
            if (!$val) {
                $set->resize = false;
            } elseif ($val === 'fit') {
                $r = $set->w1 / $set->h1;
                $set->w2 = $set->w1;
                $set->h2 = $set->h1;

                $set->x2 = floor(($set->w - $set->w2) / 2);
                $set->y2 = floor(($set->h - $set->h2) / 2);
            }
        }
    }

    static function dbg_output_1(){
        _needphp('fileUrl');
        foreach(func_get_args() as $path) {
            if ($path && is_file($path)) {
                print fileUrl($path).'<br />';
                print '<img src="'.fileUrl($path).'" />'.'<br />';
            } else {
                print '<hr />';
                print var_export($path);
                print '<hr />';
            }

        }
    }
}