<?
$Self = _site::self();
$n = $Self::nc();

$Self::req_css('banner');

$_ctx = $Self::tempCtx(array(
    'w' => false,
    'pic' => 'banner/1/banner.png',
));

$as = '';

$w = $_ctx['w'];
if ($w) {
    $as = attr::out('style', "width: {$w}px");
}

$pic = $_ctx['pic'];
?>

<div tc r class="<?=$n?>">
    <div class="<?=$n?>-cover" <?=$as?>>
		<?=_i::img($pic)?>
    </div>
    <div a class="<?=$n?>-content" fxcc>
        <div txc>
            <div class="ft-banner-title">
                Наш телефон
            </div>
            <div nobr class="ft-banner-phone">
				<?=_pro('mobile', 'format-1-html')?>
            </div>
        </div>

    </div>

</div>