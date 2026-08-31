<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

_needphp('req-');
req_web('inc/css/image1px');


$Self = _site::self();
//$n = $Self::nc();
$nT = $Self::nc('top-menu');

$tr = _css('tr0');
//$oo = gt_on('oo'); //dbg

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
$c = _css('tc-base');

?>
.ft-menu-top {
    font-family: <?=_css('f2_')?>;
    color: <?=$c?>;
    font-size: 14px;
    font-weight: 500;
}


    .<?=$nT?>-menu .ft-menu-top {
        background-image: url('<?=gdi_px(1, $c);?>');
        background-repeat: repeat-x;
        background-position: 0 18px;
   }

    .<?=$nT?>-menu:hover .ft-menu-top {
        background-position: 0 16px;
    }



.<?=$nT?> {
    <?=pcss(array(
        'display' => 'flex',
        'flex-direction' => 'row',
        //'flex-wrap' => 'wrap',
        'justify-content' => 'space-evenly',
        //'align-items' => 'center',
    ))?>

    <?=pcss('transition', array(
        //"background-color $tr",
        //"margin-top $tr"
    ))?>
}

.<?=$nT?>-menu {
    margin-left: 15px;
}
.<?=$nT?>-link {
    /*padding: 10px 25px;*/
    padding: 10px 15px;
}

@media (max-width: <?=_css::mq('header')?>px) {}