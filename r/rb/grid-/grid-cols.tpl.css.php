<?

/*
	css для вычисления ширины ячейки в процентах
	так же последняя ячейка округляется на сотые, чтобы получить ронво 100%	
*/
$Self = self_rp();
$nG = $Self::nc();

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
    //'pageNames' => false,
    'np' => $nG,
    'cols' => 0,

)); //dx($_ctx);

$np = $_ctx['np'];
$N = $_ctx['cols'];
$N1 = $N - 1;

add_etag_ctx(array(
    etag::extra(
        $nG
    ),
    __FILE__
));

$W = 100 / $N;
$Wr = round($W, 2); //relative
$Wl = 100 - $Wr * $N1; //last |tail

?>
.<?=$np?> .<?=$nG?>-cell.-o {
    width: <?=$Wr?>%;
}
<? if ($Wl !== $Wr) { ?>
    .<?=$np?> .<?=$nG?>-cell.-o<?=$N?> {
        width: <?=$Wl?>%;
    }
<? } ?>

.<?=$np?> .<?=$nG?>-sep.-o {
    display: none;
}
.<?=$np?> .<?=$nG?>-sep.-o<?=($N == 1) ? '' : $N?> {
    display: block;
}
