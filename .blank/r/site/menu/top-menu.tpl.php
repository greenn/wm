<?
_needphp('ns.class');

$Self = _site::self();
$nT = $Self::nc('top-menu');

$Self::req_css('top-menu');
//$Self::req_js('top-menu');

$data = $Self::getMenuData('top-menu');

///$list = $Self::api_data_prop('list', 'data');
//dx($data);

$_ctx = $Self::tempCtx(array());

$ftItem = 'ft-text';
$ftSubItem = 'ft-text -dec';
?>

<div class="<?=$nT?>">

	<? foreach ($data as $index => $menu) {
		$ons = ns::ol($index, count($data)); //Ordered class (last ~ '-ol') Name Stack
        $link = $menu['link'];
        $text = $menu['text'];
    ?>
    <div class="<?=$nT?>-menu <?=$ons?>">
        <a href="<?=$link?>" class="<?=$nT?>-link" tdn>
            <span class="ft-menu-top"><?=$text?></span>
        </a>
    </div>
	<? } ?>
</div>