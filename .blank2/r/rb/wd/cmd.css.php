<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
//_needphp('pcss');
//_needphp('css/dec', 'css/vu');

$Self = _rb::self();
$n = $Self::nc();

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(
        $n
    ),
    __FILE__
), SITE_CACHE);
?>

.<?=$n?>-cmd {
    position: absolute;
    z-index: 50;
}
<?// right bottom ?>
.<?=$n?>-cmd.-rb {
    top: 100%;
    right: 0;
}
.<?=$n?>-cmd.-rb .<?=$n?>-cmd-button {
    float: right;
}
<?// left bottom ?>
.<?=$n?>-cmd.-lb {
    top: 100%;
    left: 0;
}
.<?=$n?>-cmd.-lb .<?=$n?>-cmd-button {
    float: left;
}

.<?=$n?>-cmd.-ct {
    top:0%;
    left: 50%;
    <?=pcss('transform', 'translateX(-50%)')?>
}

.<?=$n?>-cmd.-cb {
    top: 100%;
    top: 116%;
    left: 50%;
    <?=pcss('transform', 'translateY(-100%) translateX(-50%)')?>
}

<?// fixed middle (top, bottom) ?>
.<?=$n?>-cmd.-ftm,
.<?=$n?>-cmd.-fbm {
    position: fixed;
    left: 50%;
    <?=pcss('transform', 'translateX(-50%)')?>;
}
.<?=$n?>-cmd.-ftm {
    top: 0;
}
.<?=$n?>-cmd.-fbm {
    bottom: 0;
}

.<?=$n?>-cmd.-ftm .<?=$n?>-cmd-button,
.<?=$n?>-cmd.-fbm .<?=$n?>-cmd-button {
    float: left;
}


.<?=$n?>-cmd-button {
    position: relative;
    border-style: outset;
    font: 10px monospace;
    line-height: 8px;
    padding: 1px;
    _color: blue;
    border-color: blue;
    <?=pcss('border-radius', '1px')?>
}



@media (min-width: <?=1600//_css::mq('1E')?>px) {
    .<?=$n?>-cmd-button {
        font-size: 14px;
        padding: 4px;
    }
}

.<?=$n?>-cmd-button.-pressed {
    border-style: inset;
    font-weight: bold;
    <?=pcss('box-shadow', 'inset 0 0 1px black')?>
    _color: green;
    border-color: green;
    top: 1px;
}