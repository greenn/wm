<?
$Self = _site::self();
$n = $Self::nc();

$Self::req_css('header');

?>

<div fxr fxi="c" class="<?=$n?>">
	<div fg class="<?=$n?>-logo" <?=_aos('fade-down-right')?>>
		<?=site_tpl('logo', 'header-logo')?>
	</div>

	<div class="<?=$n?>-menu" <?=_aos('fade-down')?>>
		<?=site_tpl('menu', 'top-menu')?>
	</div>
</div>

<div fxr="sb" fxi2="c">
    <div wp20></div>
    <div class="<?=$n?>-phone" <?=_aos('flip-right')?>>
		<?=site_tpl('contact', 'header-phone')?>
    </div>
    <div wp20 txc r class="<?=$n?>-order">
        <?=lay_tpl('button', 'r-button-1', array(
            'text' => 'Заказать',
            '@click' => "redirectTo('".page('order', 'link')."')",
        ))?>
    </div>
</div>
