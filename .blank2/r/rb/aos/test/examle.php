<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';

$Self = self_rp(); //aos

$Self::req();


$a_e = 'ease-out-cubic';

aos_set("fade-down $a_e");





ob_start(); ?>


<style type="text/css">
	MAIN { height: 2000px; position: relative }
	SECTION, A {
		font: 14px monospace;
		background-color: royalblue;
		border: 5px solid wheat;
		position: absolute;
		display: inline-block;
		padding: 20px;
	}
	A {
		font: 16px monospace;
		border-color: indianred;
		right: 0;
	}

	SECTION[data-aos-anchor="#pos-1000"], A#pos-1000 {
		border-color: mediumvioletred;
	}

	SECTION[data-aos-anchor="#pos-1200"], A#pos-1200 {
		border-color: lightseagreen;
	}

</style>

<main>
	<section style=""></section>

	<section style="top: <?=$pos = 200?>px" <?=$aos = aos_('mirror')?>>
		<?="pos $pos".' / '.$aos?>
	</section>


	<section style="top: <?=$pos = 400?>px" <?=$aos = aos_('apos:center-center')?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 600?>px" <?=$aos = aos_('pos:200', 'mirror')?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 800?>px" <?=$aos = aos_('once')?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 1000?>px" <?=$aos = aos_("a:#pos-$pos", 'apos:'.$apos = 'top-center')?>>
		<?="pos $pos".' / '.$aos?>
	</section>
	<a style="top: <?=$pos + $atop = 200?>px" id="pos-<?=$pos?>"><?="pos $pos + $atop / $apos"?></a>

	<section style="top: <?=$pos = 1200?>px" <?=$aos = aos_("a:#pos-$pos", 'apos:'.$apos = 'center-top'
		//, '_pos:-100'
	)?>>
		<?="pos $pos".' / '.$aos?>
	</section>
	<a style="top: <?=$pos - $atop = 200?>px" id="pos-<?=$pos?>"><?="pos $pos - $atop / $apos"?></a>

	<section style="top: <?=$pos = 1400?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 1600?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 1800?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 2000?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 2200?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

	<section style="top: <?=$pos = 2400?>px" <?=$aos = aos_()?>>
		<?="pos $pos".' / '.$aos?>
	</section>

</main>


<?= call_rp('aos', 'init_js', array(
	'easing' => 'ease-out-back',
	'duration' => 500,
	'offset' => 0,
), true) ?>

<?
$html = ob_get_clean();

print rp_tpl('page', 'page', array(
	'body' => $html,
	'webKit' => true,
));