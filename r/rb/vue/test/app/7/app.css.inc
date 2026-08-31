<?
    $wSide = 170;
    $pvSide = 10;
    $phSide = 15;


    $pMain = 20;
?>
BODY {
    margin: 0;
}

.link {
    text-decoration: underline;
    color: blue;
    cursor: pointer;
}

.panel-w {
    background-color: grey;
    left: 0; top: 0; bottom: 0;
    padding: <?=$pvSide?>px <?=$phSide?>px;
    width: <?=$wSide - $phSide*2?>px;
}

.body-w {
    height: 100%;
}

.head-w {
    top: 0;
    padding: 10px;
    padding-left: <?=$wSide + 10?>px;

    background-color: lightgoldenrodyellow;
}

    .section-w {
        padding: 12px;
        border: 1px dashed grey;
        margin-bottom: 12px;
    }

.main-w {
    padding: <?=$pMain?>px;
    margin-left: <?=$wSide?>px;

    background-color: lightcyan;
}


