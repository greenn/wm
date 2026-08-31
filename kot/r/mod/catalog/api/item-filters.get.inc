<?
$Self = _kmod::self();
$Catalog = _site::name('catalog');

$_ctx = $Self::tempCtx(array(
	'id' => '',
	'section' => '',
));
$id = $_ctx['id'];
$section = $_ctx['section'];

$list = array();

$itemFilters = $Catalog::db('products/getItemFilters', array(
	'id' => $id,
	'section' => $section,
));

$data = $Catalog::getFilterList($section);
foreach ($data as $name => $title) {
	$list[$name] = array(
		'title' => $title,
		'name' => $name,
		'value' => _prop($itemFilters, $name)
	);
}

return kmod_api::response(array(
	'list' => $list
));