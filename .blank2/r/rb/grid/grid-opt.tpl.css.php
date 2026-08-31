<?
/*
	css для учёты опций
		максимальная ширина для ячейки
		максимальная ширина для таблицы
*/

//_needphp('pcss');
//_needphp('css/dec', 'css/vu');

$Self = self_rp();
$nG = $Self::nc();

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
    'np' => false, //parent class
    'ng' => $nG, //class для самого grid-блока

    'wx' => false, //wmax | w-grid | w-section
    'wxI' => false, //| w-max для item
)); //dx($_ctx);

$ng = $_ctx['ng'];
$np = $_ctx['np'];
if (!$np) $np = $ng;



$wG = $_ctx['wx'];
if ($wG === true) $wG = '100%';
$wG_isAuto = ($wG === null || $wG === 'auto');
if ($wG_isAuto) $wG = false;

$wI = $_ctx['wxI'];

list($wG, $wI) = $Self::alignUnitEach(array($wG, $wI));

add_etag_ctx(array(
    //pcss_etag_ctx('transition'),
    etag::extra(
        //пришедшие аргументы не включаем
        $nG
    ),
    __FILE__
));

?>
<? if ($wG) { ?>
    .<?=$ng ? $ng : "$np .$nG"?> {
        max-width: <?=$wG?>;
    }
<? } else if ($wG_isAuto) { ?>
    .<?=$ng ? $ng : "$np .$nG" // "$ng.$nG" ?> {
        width: auto;
    }
<? } ?>

<? if ($wI) { ?>
    .<?=$np?> .<?=$nG?>-cell-w {
        max-width: <?=$wI?>;
    }
<? } ?>