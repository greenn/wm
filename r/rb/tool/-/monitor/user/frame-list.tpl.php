<?
_needphp(
	'dirUrl',
	'isOrdinal',
	'fq/merge/merge_keys_values'
);

$__dir = dirname(__FILE__);
$itemFieldOrder = array('uri', 'title', 'omnibox');

$_ctx = qtpl::ctx(array(
	'domain' => true,
	'list' => array()
), $_ctx);

$list = array();
foreach ($_ctx['list'] as $index => $data) {
	$item = $data;
	if (isOrdinal($data)) {
		$item = merge_keys_values($itemFieldOrder, $data);
	}
	$list[$index] = $item;
}

?>
<?=qtpl("$__dir/frame-list.styles.tpl.php")?>
<?=qtpl("$__dir/frame-list.scripts.tpl.php")?>

<main fxr>
<? foreach ($list as $index => $item) {
	$uri = prop($item, 'uri', false);
	//if (!$uri) $uri = 'blob:0827B944-D600-410D-8356-96E71F316FE4'; //https://stackoverflow.com/questions/47170533/how-can-vue-router-get-current-route-path-of-lazy-loaded-modules-on-page-load
	$title = prop($item, 'title', true);
	$omnibox = prop($item, 'omnibox', false);
	if ($title === true) $title = $uri;
?>
	<div frame col fxc>
		<? if ($omnibox) { ?>
            <div fxr>
                <button onclick="reloadRelFrame(this, true)">Go</button>
                <input omnibox style="width: 100%" value="<?=$omnibox === true ? $uri : $omnibox?>" />
            </div>
		<? } ?>

		<header fxr>
			<button onclick="reloadRelFrame(this)">F5</button>
			<b ph="2"><?=$title ? $title : 'нет данных' ?></b>
			<span time fg ta="r"></span>
		</header>


		<? if ($uri) { ?>
			<section iframe fg>
				<div cover cp a="ltrb" hide="yes"></div>
				<iframe src="<?=$uri?>" frameBorder="0"></iframe>
			</section>
		<? } ?>
	</div>
<? } ?>
</main>