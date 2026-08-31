<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$Self = _kot::self();
$n = $Self::nc();

$nM = $Self::nc('modal');
$nMM = $Self::nc('modal-menu');

$B_n = kot('ui', 'nc', 'button');

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nMM?>-w {
    left: 10px;
    bottom: 5px;
}

.<?=$n?>-table-w {
    margin: 10px 0;
}
.<?=$n?>-table-w.-busy {
    min-height: 100px;
}

.<?=$n?>-table {
    border-collapse: collapse;
    width: 100%;
}


.<?=$n?>-table TH {
    background-color: rgb(239, 239, 239);
}

.<?=$n?>-table TR.-odd {
    background-color: rgb(242, 242, 242);
}
.<?=$n?>-table TR.-selected {
    background-color: #f1e6e5;
}

.<?=$n?>-table TH,
.<?=$n?>-table TD {
    padding: 6px;
    border-width: 1px;
    border-style: solid;
    border-color: rgba(64, 77, 92, 0.25);
}

.<?=$n?>-table TD {
    cursor: pointer;
}

.<?=$n?>-tpl-targets {}
.<?=$n?>-targets {}


.<?=$n?>-target {
    padding-bottom: 8px;
    line-height: 11px;
}


<?//ak alink ?>
.<?=$n?>-table .link {
    color: <?=_cssKot('blue-azure')?>
}

.<?=$n?>-table .link:visited {
    color: <?=_cssKot('tekhelet')?>
}

.<?=$nMM?> *[class*="ft-"] {
    color: rgba(0, 0, 0, 0.87);
}

.<?=$nMM?>-w {
    left: 10px;
    top: 100%;
    margin-top: -5px;
}

.<?=$nMM?> {
    min-width: 200px;
    border-radius: 4px;
    background-color: white;

    <?=pcss('box-shadow', array(
        '0px 2px 4px -1px rgba(0, 0, 0, 0.2)',
        '0px 4px 5px 0px rgba(0, 0, 0, 0.14)',
        '0px 1px 10px 0px rgba(0, 0, 0, 0.12)',
    ))?>
}

.<?=$nMM?>-item.<?=$B_n?> {
    width: 100%;
}
.<?=$nMM?>-item .<?=$B_n?>-с {
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 3px;
    padding-right: 12px;
}

.<?=$nMM?>-item.-hover {
    background-color: rgba(0, 0, 0, 0.04);
}
.<?=$nMM?>-item.-click {
    background-color: #dcdcdc;
}

.<?=$nMM?>-icon {
    text-align: center;
    width: 22px;
    height: 22px;
    padding: 0 5px;
}

.<?=$nMM?>-icon .material-icons {
    vertical-align: middle;
    line-height: 23px;
    color: rgba(0, 0, 0, 0.54);
}
