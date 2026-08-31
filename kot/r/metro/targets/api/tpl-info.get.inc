<?
$ntTarget = 'targets-tpl';

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'dbg' => false
));
//$target_id = $_ctx['id'];

include 'tpl-info.cfg.inc';
$tplSections; $tplData; $tplDoc;

/*
$_tplData = $tplData;
$tplData = array();

if (true && isLocalhost) {
	$tplData['card'] = $_tplData['card'];
	$tplData['place'] = $_tplData['place'];
	$tplData['services'] = $_tplData['services'];

	$tplData['passenger'] = $_tplData['passenger'];

	$tplData['restore'] = $_tplData['restore'];
	$tplData['message'] = $_tplData['message'];

	$tplData['topup'] = $_tplData['topup'];

	$tplData['sale'] = $_tplData['sale'];
	$tplData['helpdesk'] = $_tplData['helpdesk'];

	$tplData['write'] = $_tplData['write'];

	$tplData['passes'] = $_tplData['passes'];
} else {

	$tplData = $_tplData;
	unset($tplData['card']);
}*/


$tplInfo = array();
foreach ($tplData as $catName => $catItems) {
	foreach ($catItems as $trgSubName => $item) {
		if (is_string($item)) $item = array('title' => $item, 'disabled' => !true);
		$trgName = "$catName/$trgSubName";
		$tplName = "$catName--$trgSubName";

		$item['name'] = $trgName;
		$item['tpl'] = "tpl-$tplName";
		$item['tpl2'] = "tpl2-$tplName"; //tpl2-passes--station-freq
		$item['tpl3'] = "tpl3-$tplName";
		$item['sectionTitle'] = $tplSections[$catName];

		if (isLocalhost) {
			$item['title'] = "{$item['title']} / $trgName";
			$item['cat'] = $catName;
			$item['tpl-file'] = "$trgSubName-tpl";
			$item['tpl2-file'] = "$trgSubName-tpl2";
			$item['tpl3-file'] = "$trgSubName-tpl3";

		}

		$tplInfo[$trgName] = $item;
	}

}

if ($_ctx['dbg'] === 'add-target') {
	d($tplInfo);
?>
<pre>
	<? foreach ($tplInfo as $name => $data) { ?>
		self.add_target('<?=$name?>', { initData: { value: '' } });
	<? } ?>
</pre>

<?
	exit;
}

return kot_api::response(array(
	'list' => $tplInfo
));