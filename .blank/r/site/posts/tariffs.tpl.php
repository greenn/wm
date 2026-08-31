<?
$Self = _site::self(); //site_page_content
$nT = $Self::nc('T');

$Self::req_css('tariffs');

$_ctx = $Self::tempCtx(array(
	'head' => false,
	'more' => false,
	'aos' => false,
));

$dataList = rb('data', 'getDirItems', array(
	'R' => $Self,
	'dir' => 'data/plans',
));
//dx($dataList);

$head = $_ctx['head'];
$more = $_ctx['more'];
$aos = $_ctx['aos'];

$priceMode = 2; 

//foreach (array_chunk($dataList, 3) as $list) {}
?>
<? if ($head) {
	$n_PC = site('page-content', 'nc');
	?>
	<div class="<?=$n_PC?>-w" pt50 pb30>
		<h2 txc class="ft-plan-head-title">
			Наши Предложения
		</h2>
		<h3 txc class="ft-plan-head-text">
			Каждый пакет ритуальных услуг подходит для достойного проведение похорон, учитывая индивидуальные пожелания и потребности каждой семьи.
		</h3>
	</div>
<? } ?>

	<div fxr="c" fxw class="<?=$nT?>" <?=_aos('fade-up')?>>
		<? foreach ($dataList as $item) {

			$title = $item['title'];
			$price = $item['price'];

			$list = $item['service'];
			$picType = $item['pic-type'];
        ?>
			<div class="<?=$nT?>-col">
				<div class="<?=$nT?>-item">
					<div class="<?=$nT?>-info">

                        <div class="<?=$nT?>-item-c">
                            <h3 txc class="<?=$nT?>-title ft-plan-title">
								<?=$title?>
                            </h3>
                            <div class="<?=$nT?>-list ">
                                <ul>
                                    <? foreach ($list as $li) {
                                        $text = $li;
                                    ?>
                                        <li class="ft-plan-list"><?=$text?></li>
                                    <? } ?>
                                </ul>
                            </div>
                        </div>
                        <? if ($priceMode === 1) { ?>
                        
                            <h2 txc class="<?=$nT?>-price ft-plan-price" price-mode="<?=$priceMode?>">
                                —, <?=$price?> руб.
                            </h2>

						<? } else { ?>

                            <div txc class="<?=$nT?>-price ft-plan-price" price-mode="<?=$priceMode?>">
                                <? if (0) { ?>
                                <div class="<?=$nT?>-price-label ft-plan-price-button-label">Заказать</div><? } ?>
                                <?=lay_tpl('button', 'r-button-1', array(
                                    'title' => "Заказать",
                                    'text' => "—, $price руб.",
                                    'ft' => 'ft-plan-price',
                                    '@click' => "clickFake",
                                    //'@click' => "redirectTo('".page('uslugi/vidy-predlozheniy-po-zahoroneniyu', 'link')."')",
                                ))?>
                            </div>
						<? } ?>
					</div>
				</div>
			</div>
		<? } ?>
	</div>


<? if ($more) { ?>
    <div txc pt40 pb30>
		<?=lay_tpl('button', 'r-button-1', array(
			'text' => 'Подробнее о тарифах',
			'@click' => "redirectTo('".page('uslugi/vidy-predlozheniy-po-zahoroneniyu', 'link')."')",
		))?>
    </div>
<? } ?>