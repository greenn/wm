<?
/*
	css выставляющий размеры отступов
		между ячейками
			так же если понадобится
		слева и справа от сетки (можно в пол размера)
		сверху и снизу (можно в пол разхмера)
*/
$Self = self_rp();
$nG = $Self::nc();

add_etag_ctx(array(
    //pcss_etag_ctx('transition'),
    etag::extra(
        //[nh] пришедшие аргументы из $_ctx не включаем
        $nG
    ),
    __FILE__
));

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
    'np' => $nG,
    'cols' => 0,
    's' => false, //padding size
        //'sh' => false, //size of horizonal padding
        //'sv' => false, //size of vertical padding
        
    'shs' => null, //size of side padding
    'shsHalf' => false, //брать половину размера от текущего для sh
    
    'svs' => null, //[py sides] вертикальные отступа перед и после сетки
    'svsHalf' => false, //вертикальные отступа перед и после сетки
    'svt' => null, //top - перед
    'svtHalf' => false, //
    'svb' => null, //bottom - после
    'svbHalf' => false, //
)); //dx($_ctx);

$np = $_ctx['np'];
$N = $_ctx['cols'];
$N1 = $N - 1;

//$prop = $_ctx['padding'] ? 'padding' : 'margin';

$s = $_ctx['s'];
$sh = prop($_ctx, 'sh', $s);
$sv = prop($_ctx, 'sv', $s);

$sh = $Self::alignUnit($sh);
$sv = $Self::alignUnit($sv);
$sh_ = $Self::extractUnit($sh);
//dpx($sh, prop($_ctx, 'sh'));

$shs = $Self::calcSideValue($_ctx['shs'], $_ctx['shsHalf'], $sh, $sh_);

$svs = $Self::calcSideValue($_ctx['svs'], $_ctx['svsHalf'], $sv);
$svt = $Self::calcSideValue($_ctx['svt'], $_ctx['svtHalf'], $sv);
$svb = $Self::calcSideValue($_ctx['svb'], $_ctx['svbHalf'], $sv);
//dpx($svt, $Self::alignUnit($svt));
//dpx($shs, $svs, $svt, $svb);

//dx($sh_val, $sv, $sh, $N, $N1);
?>
<? for ($n = $N1; $n >= 0; $n--) { //5 = 4 3 2 1 0
    $isLeft = $n === $N1;
    $isRight = $n === 0;

    $p = $n > 0 ? "p{$n}" : '';
    $nc = "-o{$N}$p";
    if ($N == 2 && $n == 1) $nc = '-od'; //(ak odd) вместо -o2p1
    if ($N == 1) $nc = '-o';

	//выведенные чёткие размеры
	/*
	    $ml + $mr = const
	*/
    $ml = round($sh_['val'] * ($N1 - $n) / $N, 4);
    $mr = round($sh_['val'] * $n / $N, 4);


    $ml .= $sh_['unit'];
    $mr .= $sh_['unit'];

    if ($isLeft && $shs) $ml = $shs;
    if ($isRight && $shs) $mr = $shs;
?>
    .<?=$np?> .<?=$nG?>-cell.<?=$nc?> .<?=$nG?>-cell-b {
        margin-left: <?=$ml?>; <?/*<?=$isLeft ? 'isLeft' : ''?> <?=$shs?>*/?>
        margin-right: <?=$mr?>;
    }
<? } ?>

.<?=$np?> .<?=$nG?>-sep.-o {
    height: <?=$sv?>;
}
<? if ($svs || $svt) { ?>
    .<?=$np?> .<?=$nG?>-sep.-ob {
        display: block;
        height: <?=$svt ? $svt : $svs?>;
    }
<? } ?>
<? if ($svs || $svb) { ?>
    .<?=$np?> .<?=$nG?>-sep.-ol {
        display: block;
        height: <?=$svb ? $svb : $svs?>;
    }
<? } ?>
