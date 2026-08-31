<?#1.6.1
$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'img' => '',
	'map' => array(),
	'rel' => true, //делать координаты в процентном содержании
	'max' => true,
));
$imgName = $_ctx['img'];
$max = $_ctx['max'];

$mapCfg = $_ctx['map'];

$_i = pro_opt_env('i'); //i()
//if (_x('hkIqWdImgClass')) $_i = _x('hkIqWdImgClass');

$img = $_i::data($imgName);
$w = $img['w'];
$h = $img['h'];

if ($max === true) {
	$max = $w;

    if ($hkMax = _x('hkWdFakeImgMax')) {
        dx($hkMax, $max);
        if ($hkMax < $max) {
            $max = $hkMax;
        }
    }
}

$_isRel = $_ctx['rel'];
//$isRel = false;

//dx($_ctx, $isRel);

//dx($img);

//oncontextmenu="return false;"
//nos covered

/*
    // Получаем содержимое файла
    $imageData = file_get_contents($imagePath);
    // Определяем MIME-тип файла
    $mimeType = mime_content_type($imagePath);
    // Кодируем содержимое файла в base64
    $base64Image = base64_encode($imageData);

    // Выводим <img> с base64-кодированным изображением
    echo '<img src="data:' . $mimeType . ';base64,' . $base64Image . '">';
*/

?>
<div r tc sz="<?="$w/$h"?>">
    <div nos noe covered>
        <img
            src="<?=$img['uri']?>"
            style="
                width: 100%;
                max-width: <?=$max?>px;
            "
        />
    </div>
    <? if ($mapCfg) { ?>

            <? foreach ($mapCfg as $cfg) {
                if (isOrdinal($cfg)) {
                    $cfg_o = $cfg;
                    $cfg = array(
                        'shape' => 'rect',
                        'coords' => $cfg[0],
                        'href' => _prop($cfg, 1),
                    );
                }
                $shape = _prop($cfg, 'shape', 'rect');
			    //$alt = _prop($cfg, 'alt', '');
			    $href = _prop::pik($cfg, array('href', 0));
                $coords = _prop::pik($cfg, array('coords', 'right'));
			    $isRight =  _prop::has($cfg, 'right');

                //dx($href, $isRight);

			    $isRel = $_ctx['rel'];

                $as = '';
                if ($href) $as = 'cp';
                //data-original-coords https://chatgpt.com/c/67445ad1-c204-8008-8625-2811a03751b4


                $c = explode(',', $coords);

                $css = array(
					'left' => round($c[0] / $w * 100, 2),
					'top' => round($c[1] / $h * 100, 2),
					'width' => round($c[2] / $w * 100, 2),
					'height' => round($c[3] / $h * 100, 2),
				);
                if (!$isRel) {
					$css = array(
						'left' => $c[0],
						'top' => $c[1],
						'width' => $c[2],
						'height' => $c[3],
					);
                }

                if ($isRight) {
                    $css['right'] = $css['left'];
                    unset($css['left']);
                }

            ?>
                <a <?=attr::asd(array(
					'o2' => $isRel ? null : '',
					'a b zi2' => '',
					'href' => $href,
					'style' => attr::css($css, $isRel ? '%' : 'px'),
				))?>></a>
            <? } ?>
    <? } ?>

</div>

<? if (0) { ?>
    https://imagemapper.noc.io/?utm_source=chatgpt.com#/result

    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1430 143">
        <image width="1430" height="143" xlink:href="/path/to/image"></image> <a xlink:href="#/">
            <rect x="0" y="22" fill="#fff" opacity="0" width="293" height="100"></rect>
        </a>
    </svg>


<? } ?>