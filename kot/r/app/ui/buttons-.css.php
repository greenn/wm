<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$nB = $Self::nc('button');

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.<?=$nB?> > * {
    vertical-align: middle;}
}

.<?=$nB?> .material-icons {
    font-size: 20px;

}
.<?=$nB?> .material-icons + span {
    padding-left: 6px;
}


.<?=$nB?> {
    padding: 2px 12px;
    border: none;

    border-radius: 4px;

    <?=pcss('transition', array(
        "background-color $tr"
    ))?>
}

.<?=$nB?>.-mr {
    margin-right: 10px;
}

.<?=$nB?>-c {
    min-height: 23px;
}



.<?=$nB?>[r-button] {
    background-color: <?=_cssKot('r-button-bg')?>;
    border-radius: 4px;

}
.<?=$nB?>[r-button],
.<?=$nB?>[r-button] * {
    color: white;
}

.<?=$nB?>[e-button] {
    background: none;
    border: none;
    padding: 0;
    border-radius: 0;
}




.<?=$nB?>[w-button] {
    background-color: <?=_cssKot('white')?>;
    <?=pcss('box-shadow', '0px 0px 4px rgba(0, 0, 0, 0.4)')?>
    <?=pcss('transition', array(
        "background 0.4s cubic-bezier(0.25, 0.8, 0.25, 1)",
        "box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1)",
    ))?>

}

.<?=$nB?>[r-button],
.<?=$nB?>[w-button] {
    <?=pcss('transition', array(
        "background 0.4s cubic-bezier(0.25, 0.8, 0.25, 1)",
        "box-shadow 0.28s cubic-bezier(0.4, 0, 0.2, 1)",
    ))?>
}

.<?=$nB?>[r-button].-click,
.<?=$nB?>[w-button].-click {
    <?=pcss('box-shadow', '0px 5px 5px -3px rgba(0, 0, 0, 0.2), 0px 8px 10px 1px rgba(0, 0, 0, 0.14), 0px 3px 14px 2px rgba(0, 0, 0, 0.12)')?>

}


.<?=$nB?>[w-button="wide"] .material-icons {
    margin: 0 8px;
    font-size: 14px;
}


.<?=$nB?>.-disabled {
    cursor: default;

    background-color: rgba(0, 0, 0, 0.12) !important;

    <?=pcss('transition', array(
        'background 400ms cubic-bezier(0.25, 0.8, 0.25, 1)',
        'box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1)',
    ))?>

    <?=pcss('box-shadow', array(
        '0px 0px 0px 0px rgba(0, 0, 0, 0.2)',
        '0px 0px 0px 0px rgba(0, 0, 0, 0.14)',
        '0px 0px 0px 0px rgba(0, 0, 0, 0.12)',
    ))?>
}

.<?=$nB?>.-disabled,
.<?=$nB?>.-disabled * {
    color: rgba(0, 0, 0, 0.26) !important;
}


@media (max-width: <?=_mq(2)?>px) {}