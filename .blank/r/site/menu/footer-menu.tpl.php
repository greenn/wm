<?
_needphp('ns.class');

$Self = _site::self();
$nF = $Self::nc('footer-menu');
$Self::req_css('footer-menu');

$_ctx = $Self::tempCtx(array(
    'items' => array()
));

$data = $Self::buildMenuData($_ctx['items']);

?>
<div fxr="sa" class="<?=$nF?>">
	<? foreach ($data as $index => $menu) {
        $pid = $menu['pid'];

		$ctx = defaultsDeep(_page($pid, 'footer-menu'), array(
			'pic' => '',
			'h' => '',
		));

		$pic = $ctx['pic'];
		$cssPic = array();
		$h = _prop($ctx, 'h');
		if ($h) {
			$cssPic []= "height: {$h}px";
			$cssPic []= "max-height: {$h}px";
		}

		$a_cssPic = 'style="'.join('; ', $cssPic).'"';


        $link = $menu['link'];
        $text = $menu['text'];
    ?>
        <div class="<?=$nF?>-menu">

            <div class="<?=$nF?>-icon-w" fxcc>
                <div txc class="<?=$nF?>-icon" cp @click="redirectTo('<?=$link?>')">
                    <? if ($pic) { ?>
                        <?=_i::img($pic, $a_cssPic);?>
                    <? } ?>
                </div>
            </div>
            <a b txc tdn href="<?=$link?>" class="<?=$nF?>-link ft-menu-block"><?=$text?></a>

        </div>
	<? } ?>
</div>