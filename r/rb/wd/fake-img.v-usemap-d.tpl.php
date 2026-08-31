<?#1.4.2
$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'img' => '',
	'map' => array(),
));
$imgName = $_ctx['img'];

$mapCfg = $_ctx['map'];

$a_usemap = '';
if ($mapCfg) {
    $mapMame = str_replace(array('/', '.'), '-', $imgName);
	$a_usemap = attr::out_val('usemap', "#$mapMame");
}


$img = _i::data($imgName);
dx($img);

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
<div r nos noe covered>
    <img
        src="<?=$img['uri']?>"
        style="
            width: 100%;
            max-width: <?=$img['w']?>px;
        "
        <?=$a_usemap?>
    />
    <? if ($mapCfg) { ?>
        <map name="<?=$mapMame?>">
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
                $coords = _prop($cfg, 'coords');
                $href = _prop($cfg, 'href');
                //$alt = _prop($cfg, 'alt', '');

                $as = '';
                if ($href) $as = 'cp';
                //data-original-coords https://chatgpt.com/c/67445ad1-c204-8008-8625-2811a03751b4
            ?>
                <area <?=$as?> shape="<?=$shape?>" coords="<?=$coords?>" href="<?=$href?>">
            <? } ?>

        </map>
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