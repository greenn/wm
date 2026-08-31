<?
_needphp('fq/attr.class');

$Self = _rb::self();

$map = array(
    'ms-color' => array('name' => 'msapplication-TileColor'),
    'color' => array('name' => 'theme-color'),
    'locale' => 'og:locale',
    'title' => 'og:title',
    'description' => 'og:description',
    'image' => 'og:image',
    'url' => 'og:url',
    'type' => 'og:type',
);
$mapOrdinal = array('property');


foreach ($map as $name => $cfg) {
    if (is_string($cfg)) $cfg = array($cfg);
    if (isOrdinal($cfg)) {
	    $cfg = merge_keys_values($mapOrdinal, $cfg);
	    $map[$name] = $cfg;
    }
}

$_ctx = $Self::tempCtx(array(
    'ms-color' => false,
    'color' => false,
    'locale' => false, //ru_RU

    'url' => true,
    'image' => '',
    'title' => '',
    'description' => '',
    'type' => '',
));

//dx($_ctx, $map);

if ($_ctx['url'] === true) $_ctx['url'] = URL;

?>
<? foreach ($map as $name => $cfg) {
	$value = prop($_ctx, $name);
	//d($value, $_ctx, $name);
	if (!$value) continue;

	$value = attr::value($value);

    $ac = array();
	$name = prop($cfg, 'name');
	$property = prop($cfg, 'property');
	if ($name) $ac []= "name=\"$name\"";
	if ($property) $ac []= "property=\"$property\"";

?>
    <meta <?=join(' ', $ac)?> content="<?=$value?>">
<? } //exit; ?>