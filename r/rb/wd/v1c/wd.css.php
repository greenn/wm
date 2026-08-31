<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
//_needphp('pcss');
//_needphp('css/dec', 'css/vu');

$Self = _rb::self();
$vn = $Self::relDir();
$n = $Self::nc($vn);

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(
        $n
    ),
    __FILE__
), SITE_CACHE);
?>


.<?=$n?> {
    display: block;
    position: relative;
}


.<?=$n?>-view {
    position: absolute;
    z-index: 5;
    left: 0; top: 0;
}

.<?=$n?>.-o > .<?=$n?>-view {
    outline: 1px solid mediumaquamarine;
}

.<?=$n?>-src {
    position: relative;
    width: 100%;
    height: 100%;
    background-position: left top;
    background-repeat: no-repeat
}

.<?=$n?>-embody {
    position: relative;
    z-index: 10;
    height: 100%;
}

.<?=$n?>.hover1:hover > .<?=$n?>-view {
    filter: invert(75%);
}
.<?=$n?>.hover1:hover > .<?=$n?>-embody {
    opacity: .5;
}

.<?=$n?>.hover2:hover > .<?=$n?>-view {
    filter: hue-rotate(230deg);
}
.<?=$n?>.hover2:hover > .<?=$n?>-embody {
    opacity: .5;
}