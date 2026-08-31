<?
# https://codepen.io/alphardex/pen/NWxOqRb
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$Self = _rp::self();

//$bg = _css('white');
//$c_shadow = hex2rgb('#000', .5);

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.clock-loader {
    --primary-color: <?=_css('white')?>;
    --clock-color: var(--primary-color);
    --clock-width: 20px;
    --clock-radius: calc(var(--clock-width) / 2);
    --clock-minute-length: calc(var(--clock-width) * 0.4);
    --clock-hour-length: calc(var(--clock-width) * 0.2);
    --clock-thickness: 1px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    width: var(--clock-width);
    height: var(--clock-width);
    border: 2px solid var(--clock-color);
    border-radius: 50%;
}
.clock-loader::before, .clock-loader::after {
    position: absolute;
    content: "";
    top: calc(var(--clock-radius) * 0.25);
    width: var(--clock-thickness);
    background: var(--clock-color);
    border-radius: 10px;
    transform-origin: center calc(100% - calc(var(--clock-thickness) / 2));
    animation: spin infinite linear;
}
.clock-loader::before {
    height: var(--clock-minute-length);
    animation-duration: 2s;
}
.clock-loader::after {
    top: calc(var(--clock-radius) * 0.25 + var(--clock-hour-length));
    height: var(--clock-hour-length);
    animation-duration: 15s;
}

@keyframes spin {
    to {
        transform: rotate(1turn);
    }
}