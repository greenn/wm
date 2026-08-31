<?
    include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
    _needphp('pcss');
    _needphp('css/dec', 'css/vu');
    _needphp('fq/merge/am');

    $Self = self_rp();

    $n = $Self::nc();
    $cid = basename(dirname(__FILE__)); //cont-types
    $nc = $Self::nc().'[name="'.$cid.'"]';
    $n_G = call_rp('grid', 'nc');


    $tr = data_css('tr0');

    headers('css', 'utf8', 'nosniff', etag::ctx(
        pcss_etag_ctx('transition'),
        etag::extra(
            $n, $n_G,
            $tr
        ),
        __FILE__
    ), SITE_CACHE);

    $G_s = 30;
    $G_ctx = array(
        //'np' => "$nc .$n_G",
        'np' => "$nc",
        'padding' => true,
    );
    $G_ctxS = am($G_ctx, array(
        's' => $G_s,
    ));

?>

<? call_rp('grid', 'cssTpl', 'grid', array(
    'np' => $nc,
    'cols' => 5,
    'wx' => 1050,
	'wxI' => 270,
	's' => 30,

    'mq_' => array(
        array(MQ3B, array(
            'cols' => 2,
        )),
        array(MQ3, array(
            'cols' => 1,
            'sv' => 0,
        )),
    ),

    /* ext-eg
            <?=call_rp('grid', 'cssTpl', 'grid'

        'mq_' => array(
            array(MQX, array(
                'sv' => _vw($SG_pv, MQX),
                'sh' => _vw($SG_ph, MQX),
            )),
            array(1500, array(
                'cols' => 2,
            )),
            array(array(MQ2B, 1000), array(
                'cols' => 1,
            )),
            array(array(MQ2B), array(
                'cols' => 2,
            )),
            array(MQ3B, array(
                'cols' => 1,
            )),
        ),
    */

))?>

<?=call_rp('grid', 'cssTpl', 'grid-cols', am($G_ctx, array(
    'cols' => 3,
)))?>
<?=call_rp('grid', 'cssTpl', 'grid-sz', am($G_ctxS, array(
	'cols' => 3,
)))?>

<?=call_rp('grid', 'cssTpl', 'grid-opt', am($G_ctxS, array(
	'wx' => 1050,
	'wxI' => 270,
)))?>

<? if (!1) { ?>
    <?=call_rp('grid', 'cssTpl', 'grid-cols', am($G_ctx, array(
        '_mq' => MQ3B,
        'cols' => 2,
    )))?>
    <?=call_rp('grid', 'cssTpl', 'grid-sz', am($G_ctxS, array(
        '_mq' => MQ3B,
        'cols' => 2,
    )))?>

    <?=call_rp('grid', 'cssTpl', 'grid-cols', am($G_ctx, array(
        '_mq' => MQ3,
        'cols' => 1,
    )))?>
    <?=call_rp('grid', 'cssTpl', 'grid-sz', am($G_ctxS, array(
        '_mq' => MQ3,
        'cols' => 1,
    )))?>

<? } else {?>
    @media (max-width: <?=MQ3B?>px) {
        <?=call_rp('grid', 'cssTpl', 'grid-cols', am($G_ctx, array(
            'cols' => 2,
        )))?>
        <?=call_rp('grid', 'cssTpl', 'grid-sz', am($G_ctxS, array(
            'cols' => 2,
        )))?>
    }

    @media (max-width: <?=MQ3?>px) {
        <?=call_rp('grid', 'cssTpl', 'grid-cols', am($G_ctx, array(
            'cols' => 1,
        )))?>
        <?=call_rp('grid', 'cssTpl', 'grid-sz', am($G_ctx, array(
            'cols' => 1,
            's' => 15,
        )))?>
    }
<? } ?>

<? if (1) { ?>

    .<?=$nc?> .<?=$n_G?> .<?=$n_G?>-cell-b {
        outline: 1px dashed lightseagreen;
    }

<? }  ?>

.<?=$nc?> .<?=$n_G?>-cell-c {
    padding: 15px;
    text-align: center;
}
