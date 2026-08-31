<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');
$nTC = $Self::nc('top-cmd');

$tr = _cssKot('tr0');
//$trSide = '400ms cubic-bezier(0.25, 0.8, 0.25, 1)';

$wSide = _cssKot('w-side');
$ph = _cssKot('app-ph'); // —
$pv = _cssKot('app-pv'); // |
?>
HTML, BODY {
    height: 100%;
}
BODY {
    background-color: grey;
    background: linear-gradient(0deg, #fff1eb, #3c5d95);
    <?/*
    -1background-color: <?=_cssKot('main-bg')?>;
    -1background: linear-gradient(45deg, #a8edea, #fed6e3);
    -background: linear-gradient(45deg, #37ecba, #72afd3);
    -1background: linear-gradient(45deg, #9890e3, #b1f4cf);

    -background: linear-gradient(45deg, #30cfd0, #330867);
    -1background: linear-gradient(45deg, #f5f7fa, #c3cfe2);
    -1background: linear-gradient(45deg, #d299c2, #fef9d7);
    -background: linear-gradient(45deg, #fddb92, #d1fdff);
    */?>
}

<?#mb-mvd kot/r/app/css/layout.css.inc ?>
.sep-v { /* отступ "вертикальый разделитель"  |  */
    height: <?=$pv?>px;
    /*background-color: rgba(0,0,0,0.2);*/
}

.sep-h { /* отступ "горизонтальны разделитель"  —  */
    margin-left: <?=$ph?>px;
    margin-right: <?=$ph?>px;
}
.sep-hw { /* шириной отступ "горизонтальны разделитель"  —  */
    width: <?=$ph?>px;
}
.sep-hw2 { /* шириной отступ "горизонтальны разделитель"  —  */
    width: <?=floor($ph / 2)?>px;
}
.sep-hw3 { /* шириной отступ "горизонтальны разделитель"  —  */
    width: <?=floor($ph / 3)?>px;
}
.sep-hw4 { /* шириной отступ "горизонтальны разделитель"  —  */
    width: <?=floor($ph / 4)?>px;
}
<?#\mb-mvd?>


.<?=$n?> {
    /*hmp100*/
    /*background-color: rgba(0,0,0,0.4);*/
    padding-left: <?=$wSide + $ph?>px;
}



.<?=$n?>-side {
    /*hmp100*/
    display: block;
    margin-left: <?=$ph?>px;
    width: <?=$wSide?>px;
}



.<?=$n?>-main {
    height: 100%;

}


.<?=$n?>-content {}

    .<?=$n?>-content [size="titul-1"]{
        min-height: 105px;
    }
