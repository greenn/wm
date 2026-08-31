<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'
);
$Self = _kot::self();
//$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	$js['provide/crud'] = $Self::path('provide/crud.js.inc'),
		$js['provide/crud/create'] = $Self::path('provide/crud/create.js.inc'),
		$js['provide/crud/update'] = $Self::path('provide/crud/update.js.inc'),
		$js['provide/crud/remove'] = $Self::path('provide/crud/remove.js.inc'),
		$js['provide/crud/copy'] = $Self::path('provide/crud/copy.js.inc'),
		$js['provide/crud/aproove'] = $Self::path('provide/crud/aproove.js.inc'),
		$js['provide/crud/reject'] = $Self::path('provide/crud/reject.js.inc'),
		$js['provide/crud/coverage'] = $Self::path('provide/crud/coverage.js.inc'),
	$js['provide/crud-form'] = $Self::path('provide/crud-form.js.inc'),
	$js['provide/crud-item'] = $Self::path('provide/crud-item.js.inc'),
	$js['provide/crud-modal'] = $Self::path('provide/crud-modal.js.inc'),
	__FILE__
), SITE_CACHE);
?>

<? include $js['provide/crud']; ?>

<? include $js['provide/crud-form']; ?>

<? include $js['provide/crud-item']; ?>

<? include $js['provide/crud-modal']; ?>