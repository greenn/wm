<?

$Self = _rb::self();

$map = array(
	'apple-touch-icon' => array('sizes' => '180x180', 'rel' => 'apple-touch-icon', 'type' => false),
	'32' => array('sizes' => '32x32', 'rel' => 'icon'),
	'16' => array('sizes' => '16x16', 'rel' => 'icon'),
);

$_ctx = $Self::tempCtx(array(
	'imgDir' => 'favicon',
	'imgSubDir' => '',
	'data' => array(),
));

$data = $_ctx['data'];
$imgDir = $_ctx['imgDir'];
$imgSubDir = $_ctx['imgSubDir'];
if ($imgSubDir) $imgDir .= "/$imgSubDir";

?>
<? foreach ($data as $name => $uri) {
    $cfg = $map[$name];
    $ni = "$imgDir/$uri"; //image name
	$pi = _i::path($ni); //image path

    $url = _i::uri("$imgDir/$uri");
    $rel = prop($cfg, 'rel', 'icon');
    $size = prop($cfg, 'sizes', "{$name}x{$name}");
    $type = prop($cfg, 'sizes', "{$name}x{$name}");

	$a_type = "";
    if (prop($cfg, 'type', true)) {
	    $mime = mime_content_type($pi);
        $a_type = "type=\"$mime\"";
    }
?>
    <link rel="<?=$rel?>" sizes="<?=$size?>" <?=$a_type?> href="<?=$url?>">
<? } ?>