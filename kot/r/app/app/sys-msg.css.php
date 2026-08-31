<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$nSM = $Self::nc('sys-msg');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nSM?> {
    right: 20px;
    bottom: 20px;
    z-index: 3500;
}


.<?=$nSM?>-item {
    float: right;
    clear: right;
    width: 280px;
    padding: 12px 30px;
    padding-top: <?=12 + 7?>px;
    padding-right: 20px;

    background-color: <?=_cssKot('seasalt')?>;
    margin-bottom: 2px;
}

.<?=$nSM?>-item * {
    color: white;
}

.<?=$nSM?>-item.-error {
    background-color: #f53b1f;
}

.<?=$nSM?>-item.-success {
    background-color: #7ec419;
}


.<?=$nSM?>-icon {
    width: 60px;
    height: 60px;
    margin-left: 5px;
}

.<?=$nSM?>-icon {
    background-repeat: no-repeat;
    background-position: center center;
    background-size: auto;
}

.<?=$nSM?>-item.-error .<?=$nSM?>-icon {
    background-image: url('<?=kot_i::uri('icon/sys-msg/msg-error.png')?>')
}

.<?=$nSM?>-item.-success .<?=$nSM?>-icon {
    background-image: url('<?=kot_i::uri('icon/sys-msg/msg-success.png')?>')
}


.<?=$nSM?>-bar {
    height: 7px;
    background-color: black;
    opacity: 0.1;
}


.<?=$nSM?>-bar {
    <?=pcss('animation', "3s forwards $nSM-bar")?>
    <?//=pcss('animation-timing-function', cbn('easeOutCirc'))?>
    <?//=pcss('animation-iteration-count', 'infinite')?>
    <?//=pcss('animation-fill-mode', 'forwards')?>
}

.<?=$nSM?>-item.-stop .<?=$nSM?>-bar,
.<?=$nSM?>-item.-pause .<?=$nSM?>-bar {
    animation-play-state: paused;
}


<?=pcss('keyframes', "$nSM-bar", array(
      '0%' => 'width: 0',
      '100%' => 'width: 100%',
))?>
