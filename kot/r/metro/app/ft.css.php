<?#3.1.0q
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers', 'img/i_');

$Self = _kot::self();

$f0 = _cssKot('f0'); //sans-serif
$f1 = _cssKot('fM'); //~ ffs (Roboto)
//dx($f1, $f0);

$_FS = _cssKot('fs_'); //конфиги размеров шрифтов из  iq/css.php:38

$fs0 = $_FS['t'][1]; //font-size от ft-text

$tr = _cssKot('tr0');
$trq = _cssKot('trq1');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra($tr, $trq),
    __FILE__
));
?>


HTML {
    font-family: <?=$f1?>, <?=$f0?>;
    font-size: <?=$fs0?>px;
    color: <?=_cssKot('black-text')?>;
}

    A, .link {
        cursor: pointer;
        text-decoration: underline;

        display: inline-block;
        color: <?=_cssKot('black-text')?>;
    }
    A:hover, .link:hover {}

A[nolink] { cursor: default; }
A[nolink][cp] { cursor: pointer; }


/*A[class*="ft-"], A *[class*="ft-"], A [tq], A {
    color: <?=_cssKot('white')?>;
}*/


*[class*="ft-"] .-uc,
*[class*="ft-"].-uc {
    text-transform: uppercase;
}
*[class*="ft-"] .-lc,
*[class*="ft-"].-lc {
    text-transform: lowercase;
}

<?
$list_ncF = array(); foreach ($_FS as $name => $cfg) $list_ncF []= $cfg[0];
$list_ncF []= '.ftq';
foreach ($list_ncF as $sr) { ?>
<?=$sr?> {
    <?=pcss('transition', array(
        "font-size $trq",
        "line-height $trq",
        "letter-spacing $trq",
        "color $tr",
        "font-weight $tr", //не работает
    ))?>
}
<? } ?>

<? foreach ($_FS as $id => $set) {
    if ($alt = prop($set, 'use_alt')) {
        $_alt = prop($set, 'alt', array());
        $set = array_replace($set, $_alt);
        $fw = prop($set, array('fw', 2), 400);
        //dx($set, $alt, $_alt, $fw);
    }
    $sr = $set[0];
    $fs = $set[1];
    $ff = prop($set, 'ff', "$f1, $f0");
    $fw = prop($set, array('fw', 2), 400);
    $fh = prop($set, 'fh');
    $fc = prop($set, 'fc', 'black-text');
    //if ($id === 'l-hg') dx($set);
    $ls = prop($set, 'ls');
?>
<?=$sr?> {
    font-family: <?=$ff?>;
    font-size: <?=$fs?>px;
    font-weight: <?=$fw?>;
    font-style: normal;
<? if ($fc !== false) { ?>
    color: <?=_cssKot($fc)?>;
<? } ?>
<? if ($fh) { ?>
    line-height: <?=$fh?>px;
<? } ?>
<? if ($ls) { ?>
    letter-spacing: <?=$ls?>px;
<? } ?>
}
<?//MQ для fonts сразу после объявления
if ($mq = prop($set, 'mq')) {
    if (isOrdinal($mq)) { dx($mq, $set); }
    foreach ($mq as $mqName => $fs) {
        //if (!is_string($fs))
?>
@media (max-width: <?=_cssKot::mq($mqName)?>px) {
    <?=$sr?> {
        font-size: <?=$fs?>px;
    }
}
    <? } ?>
<? } ?>

<? } ?>

<? foreach (array(
    #'thn' => 100, //Thin
    #'elgt' => 200, //Extra-light
    'lgt' => 300, //Light
    'reg' => 400, //Regular (Normal, Book)
    'med' => 500, //Medium
    //'sbld' => 600, //Semi-bold (Demi-bold)
    'bld' => 700, //Bold
    //'ebld' => 800, //Extra-bold (Heavy)
    //'blk' => 900, //Black
) as $cls => $val) {
    $cls = "w-$cls"
?>
*[class*="ft-"].<?=$cls?>,
*[class*="ft-"] .<?=$cls?>,
*[class*="ft-"].<?=$cls?>_,
*[class*="ft-"].<?=$cls?>_ *,
*[class*="ft-"] .<?=$cls?>_,
*[class*="ft-"] .<?=$cls?>_ * {
    font-weight: <?=$val?>;
}
<? } ?>

*[class*="ft-"].s-i,
*[class*="ft-"] .s-i,
*[class*="ft-"].s-i_,
*[class*="ft-"].s-i_ * {
    font-style: italic;
}

<? foreach (array(
    'red' => 'fire-red',
    'blue' => 'blue-azure',
) as $cls => $val) {
    //$cls = "c-$cls"
?>
.-<?=$cls?>,
*[class*="ft-"].-<?=$cls?>,
*[class*="ft-"] .-<?=$cls?> {
    color: <?=_cssKot($val)?>;
}
<? } ?>



<? foreach (_cssKot('ffs') as $n => $cfg) {
    $ff = $cfg[0]; //if (has_space) "'ffs'"
?>
*[class*="ft-"].-ff<?=$n?> {
    font-family: <?=$ff?>;
}
<? } ?>

.material-icons {
    font-size: 16px;
}
