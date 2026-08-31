<?//dd
# https://codepen.io/sudeepgumaste/pen/abdrorB
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
.circles *, .circle *::before, .circle *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


.circles {
    width: 100%;
    height: 100%;
    /*background: #1a237e;*/
    display: flex;
    justify-content: center;
    align-items: center;
    /*box-shadow: 4px 4px 20px rgba(0, 0, 0, 0.3);*/
}

.container {
    height: 15px;
    width: 105px;
    display: flex;
    position: relative;
}
.container .circle {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: #fff;
    animation: move 500ms linear 0ms infinite;
    margin-right: 30px;
}
.container .circle:first-child {
    position: absolute;
    top: 0;
    left: 0;
    animation: grow 500ms linear 0ms infinite;
}
.container .circle:last-child {
    position: absolute;
    top: 0;
    right: 0;
    margin-right: 0;
    animation: grow 500ms linear 0s infinite reverse;
}

@keyframes grow {
    from {
        transform: scale(0, 0);
        opacity: 0;
    }
    to {
        transform: scale(1, 1);
        opacity: 1;
    }
}
@keyframes move {
    from {
        transform: translateX(0px);
    }
    to {
        transform: translateX(45px);
    }
}