<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$nS3d1 = $Self::nc('S3d-1');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
<? if (!true && 'dbg') { ?>
    :root {
        <? $h = 400; ?>
        <? $pic = 'posts/1/pic2.jpg'; ?>

        <?="--$nS3d1"?>-S-h: <?=$h?>px>;
        <?="--$nS3d1"?>-B-h: <?=$h?>px>;
        <?="--$nS3d1"?>-BS-h: <?=floor($h * .8)?>px;

        <?="--$nS3d1"?>-S-h: 100%;
        <?="--$nS3d1"?>-B-h: 100%;
        <?="--$nS3d1"?>-BS-h: 80%;

        <?="--$nS3d1"?>-pic: url(<?= _i::uri($pic)?>);
    }
<? } ?>


.<?=$nS3d1?>-w {

}

.<?=$nS3d1?> {
    position: relative;
    width: 80%;
    margin: 2rem auto;
    transform-origin: 50% -5%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block {
    position: absolute;
    height: 100%;
    width: 30%;
    perspective: 1000px;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(1) {
    height: 80%;
    <?if (0) { ?>height: var(<?="--$nS3d1"?>-BS-h);<? } ?>
    top: 10%;
    left: 17%;

    width: 15%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(2) {
    top: 0;
    left: 35%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(3) {
    height: 80%;
    <?if (0) { ?>height: var(<?="--$nS3d1"?>-BS-h);<? } ?>
    top: 10%;
    left: 64%;

    width: 15%;
}


    .<?=$nS3d1?>.-narrow  {
        width: 100%;
    }
    .<?=$nS3d1?>.-narrow > .<?=$nS3d1?>-block:nth-of-type(1) {
        left: 19%;
    }

    .<?=$nS3d1?>.-narrow > .<?=$nS3d1?>-block:nth-of-type(3) {
        left: 62%;
    }



    .<?=$nS3d1?>.-wide  > .<?=$nS3d1?>-block:nth-of-type(1) {
        width: 22%;
        left: 12%;
    }

    .<?=$nS3d1?>.-wide  > .<?=$nS3d1?>-block:nth-of-type(2) {
        width: 50%;
    }

    .<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(3) {
        width: 20%;
        left: 78%;

        height: 70%;
        top: 15%;
    }

    <? if (0) { ?>

        .<?=$nS3d1?>.-wide  > .<?=$nS3d1?>-block:nth-of-type(2) {
            width: 70%;
        }

        .<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(3) {
            left: 94%;
        }

    <? } ?>

    .<?=$nS3d1?> > .<?=$nS3d1?>-block > .<?=$nS3d1?>-side {
    position: absolute;
    top: 0;
    left: 0;
    <?//background-image: url('e1/1025-1024x768.jpg');?>
    <?if (0) { ?>background-image: background-image: var(<?="--$nS3d1"?>-pic);<? } ?>
    background-size: auto 100%;
    box-shadow: -1vw 0.5vw 1vw rgba(0, 0, 0, 0.3);
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block > .<?=$nS3d1?>-side.-main {
    height: 100%;
    width: 100%;
    transform: rotateY(30deg);
    transform-origin: 0 50%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block > .<?=$nS3d1?>-side.-left {
    height: 100%;
    width: 20%;
    transform-origin: 0 50%;
    transform: rotateY(-60deg) translateX(-100%);
    filter: brightness(40%);
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(1) > .<?=$nS3d1?>-side.-main {
    background-position: 4% 50%;
    background-size: auto 130%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(1) > .<?=$nS3d1?>-side.-left {
    background-position: 0 50%;
    background-size: auto 130%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(2) > .<?=$nS3d1?>-side.-main {
    background-position: 50% 0;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(2) > .<?=$nS3d1?>-side.-left {
    background-position: 28.5% 0;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(3) > .<?=$nS3d1?>-side.-main {
    background-position: 96% 50%;
    background-size: auto 130%;
}
.<?=$nS3d1?> > .<?=$nS3d1?>-block:nth-of-type(3) > .<?=$nS3d1?>-side.-left {
    background-position: 78% 50%;
    background-size: auto 130%;
}
