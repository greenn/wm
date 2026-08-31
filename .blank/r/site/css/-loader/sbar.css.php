<?
# https://codepen.io/Bilal1909/pen/zYqrdRe
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$Self = _rp::self();

$bg = _css('white');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.sbar-w {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
}

.sbar {
    width: 7px;
    height: 25px;
    margin-top: 4px;

    display: inline-block;
    transform-origin: bottom center;
    border-top-right-radius: 20px;
    border-top-left-radius: 20px;
    /*   box-shadow:5px 10px 20px inset rgba(255,23,25.2); */
    animation: loader .8s linear infinite;
}
.bar1 {
    animation-delay: 0.1s;
}
.bar2 {
    animation-delay: 0.2s;
}
.bar3 {
    animation-delay: 0.3s;
}
.bar4 {
    animation-delay: 0.4s;
}
.bar5 {
    animation-delay: 0.5s;
}
.bar6 {
    animation-delay: 0.6s;
}
.bar7 {
    animation-delay: 0.7s;
}
.bar8 {
    animation-delay: 0.8s;
}

@keyframes loader {
    0% {
        transform: scaleY(0.1);
        background: ;
    }
    50% {
        transform: scaleY(1);
        background: <?=$bg?>;
    }
    100% {
        transform: scaleY(0.1);
        background: <?=$bg?>;
    }
}
