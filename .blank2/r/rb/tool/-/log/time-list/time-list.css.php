<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-log');
$nLT = $Self::nc('time-list');

headers('css', 'utf8', 'nosniff', etag::ctx(__FILE__));
?>

.<?=$nLT?> {
    font-size: 12px;
}

.<?=$nLT?> [s-toggle] {
    margin-right: 10px;
}

.<?=$nLT?>-item {}
.<?=$nLT?>-rec-headline {
    padding: 4px;
    margin-left: 10px;
}

.<?=$nLT?>-rec {
    padding: 5px 0;
    margin-left: 30px;
}

.<?=$nLT?>-rec-headline [url] {
    color: #2E950A;
    margin-left: 15px;
    font-size: 12px;
}


.<?=$nLT?>-item-title {
    padding: 4px;
    margin-left: 30px;
    font-size: 14px;
}

.<?=$nLT?>-item-title [time]{
    font-size: 12px;
    color: midnightblue;
    margin-right: 10px;
}

.<?=$nLT?>-item[type="log"] [msg] {
    color: dodgerblue;
}


.<?=$nLT?>-item-content {
    margin-left: 35px;
    position: relative;
    background-color: lightgoldenrodyellow;

}
<? if (0) { ?>

    .<?=$nLT?>-item-content:before,
    .<?=$nLT?>-item-content:after {
        content: '';
        position: absolute;
        left: 0; top: 0;
        background-color: black;
    }
    .<?=$nLT?>-item-content:before {
        height: 1px;
        width: 100%;
        max-width: 200px;
    }
    .<?=$nLT?>-item-content:after {
        width: 1px;
        height: 100%;
        max-height: 80px;
    }

<? } ?>