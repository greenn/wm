.a-yflip {
    <?//=pcss('animation', "300ms 1s infinite BOTH yflip")?>
    <?=pcss('animation', "300ms yflip")?>
    <?=pcss('animation-timing-function', cbn('easeOutCirc'))?>
}

<?=pcss('keyframes', 'yflip', array(
    '0%' => pcss('transform', array(
        //'rotateX(0deg)',
        'rotateY(0deg)',
    )),
    '100%' => pcss('transform', array(
        //'rotateX(720deg)',
        'rotateY(360deg)',
    ))
))?>