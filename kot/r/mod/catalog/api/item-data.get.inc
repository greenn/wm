<?
$Self = _kmod::self();


$_ctx = $Self::tempCtx(array(
	'type' => 'tombs',
	'id' => '',
));

$type = $_ctx['type'];
$id = $_ctx['id'];


$Catalog = _site::name('catalog');
$itemData = $Catalog::api_data_prop('item', 'product', array(
	'type' => $type,
	'id' => $id
));

return kmod_api::response(array(
	'item' => $itemData,
));