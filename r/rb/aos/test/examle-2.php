<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';

$Self = self_rp(); //aos

$Self::req();


$a_e = 'ease-out-cubic';

aos_set("fade-down $a_e");


/*
    Ответ
        блок появляется сразу,
        когда он находиться в зоне видимости экране

            это без дополнительных offet'ов
*/

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

</style>

<main>
	<section style=""></section>

    <a style="top: <?=$pos = 400?>px">
	    <?="anchor: pos $pos".' / '.$aos = aos_('mirror')?>
    </a>
	<section
        style="top: <?=$pos?>px"
        <?=$aos?>
        <?// data-aos-offset="20%"?>
    >
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