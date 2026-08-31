<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nPT1 = $Self::nc('PT1');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>


.<?=$nPT1?>  {
    padding-bottom: 50px;
}

.<?=$nPT1?> P {
    margin-bottom: 40px;
    line-height: 120%;
}

.<?=$nPT1?>-pic.-top {
    margin-bottom: 50px;
}

.<?=$nPT1?>-pic.-middle IMG {
    max-height: 300px;
    ;
}

.<?=$nPT1?>-pic.-middle {
    display: table;
    margin: 50px auto
}