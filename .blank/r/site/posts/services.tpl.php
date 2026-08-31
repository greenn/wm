<?
$Self = _site::self(); //site_page_content
$nS = $Self::nc('S');

$Self::req_css('services');

$_ctx = $Self::tempCtx(array(
    'head' => false,
    'more' => false,
    'use-links' => false,
));

$dataList = rb('data', 'getDirItems', array(
	'R' => $Self,
	'dir' => 'data/service',
));

$head = $_ctx['head'];
$more = $_ctx['more'];
$useLinks = $_ctx['use-links'];

//foreach (array_chunk($dataList, 3) as $list) {}
?>
<? if ($head) {
	$n_PC = site('page-content', 'nc');
?>
    <div class="<?=$n_PC?>-w" pt50 pb30>
        <h2 txc class="ft-service-head-title">
            Наши Услуги
        </h2>
        <h3 txc class="ft-service-head-text">
            Профессиональная организация похорон.
            <br />
            Все для проведения похорон
        </h3>
    </div>
<? } ?>

<div fxr="c" fxw class="<?=$nS?>">
	<? foreach ($dataList as $item) {
		$iconName = $item['icon'];
		$isSvg = _prop($item, 'icon-is-svg');

		$title = $item['title'];
		$text = $item['short'];
	?>
		<div class="<?=$nS?>-col">
			<div class="<?=$nS?>-item" <?=_aos('fade-up')?>>
				<div r class="<?=$nS?>-pic-w">
                    <div a ach oh class="<?=$nS?>-pic-sh"></div>
					<div r mc class="<?=$nS?>-pic">
						<?//=$isSvg ? _i::svg($iconName) : _i::img($iconName) ?>
						<?=_i::img($iconName, 'avh r') ?>
					</div>
				</div>

				<div txc class="<?=$nS?>-info">
					<h4 txc class="<?=$nS?>-title ft-service-title">
						<? if ($useLinks) { ?>
                            <a href="<?=URI?>#" class="ft-service-title"><?=$title?></a>
						<? } else { ?>
							<?=$title?>
						<? }?>
					</h4>
					<div txc class="<?=$nS?>-text ft-service-text">
						<?=$text?>
					</div>
				</div>
			</div>
		</div>
	<? } ?>
</div>

<? if ($more) { ?>
    <div txc pt40 pb30>
		<?=lay_tpl('button', 'r-button-1', array(
			'text' => 'Подробнее об услугах',
			'@click' => "redirectTo('".page('uslugi/ritualnye-uslugi', 'link')."')",
		))?>
    </div>
<? } ?>

<?//=rb('wd', 'fake', 'services-1.png')?>