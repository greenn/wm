<?
_needphp('ns.class');
_needphp('fq/arr/defaultsDeep');


$Self = _site::self();
$nB = $Self::nc('block-menu');
$Self::req_css('block-menu');

$_ctx = $Self::tempCtx(array(
    'items' => array()
));

$data = site_menu::buildMenuData($_ctx['items']);


?>
<div class="<?=$nB?>">
	<? foreach ($data as $index => $menu) {
        $pid = $menu['pid'];

        $ctx = defaultsDeep(_page($pid, 'block-menu'), array(
            'pic' => 'fake/diz_31.png',
            'size' => 1,
            'hover' => 1,
        ));

        $pic = $ctx['pic'];
        $iPic = _i::uri($pic);
        $cssPic = array(
			//'background-image' => "url('$iPic')"
			"background-image: url('$iPic')"
		);

        $bgPos = _prop($ctx, 'bg-pos');
        if ($bgPos) {
			$cssPic []= "background-position: $bgPos";
        }

		$bgSize = _prop($ctx, 'bg-size');
		if ($bgSize) {
			$cssPic []= "background-size: $bgSize";
		}

		$size = $ctx['size'];
		$hover = $ctx['hover'];

        $link = $menu['link'];
        $text = $menu['text'];

        $a_cssPic = 'style="'.join('; ', $cssPic).'"';
		//d($ctx, $cssPic, $a_cssPic);
    ?>
        <div class="<?=$nB?>-menu" size="<?=$size?>" hover="<?=$hover?>">

            <div r class="<?=$nB?>-pic-w" cp @click="redirectTo('<?=$link?>')">
                <div class="<?=$nB?>-pic" <?=$a_cssPic?>></div>
                <div al class="<?=$nB?>-cover"></div>
            </div>

            <a b tdn txc href="<?=$link?>" class="<?=$nB?>-link ft-menu-block"><?=$text?></a>

        </div>
	<? } ?>
</div>