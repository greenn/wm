<?
$Self = _kot::self();
$nP = $Self::nc('Pp');
?>
.<?=$nP?> {
    z-index: 3000;
    background-color: rgba(0, 0, 0, 0.32);
}

.<?=$nP?>-c {
    border-radius: 4px;
    background-color: white;
    display: table;
    padding: 20px;

<?=pcss('box-shadow', array(
	'0px 11px 15px -7px rgba(0, 0, 0, 0.2)',
	'0px 24px 38px 3px rgba(0, 0, 0, 0.14)',
	'0px 9px 46px 8px rgba(0, 0, 0, 0.12)',
))?>
}

.<?=$nP?>-headline {
    padding-top: 8px;
    padding-bottom: 22px;
}

.<?=$nP?>-msg {
    padding-bottom: 18px;
}

.<?=$nP?>-submit {
    margin-left: 7px;
}