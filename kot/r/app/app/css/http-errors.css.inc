<?
$Self = _kot::self();
$nEH = $Self::nc('EH'); //http-error
?>

.<?=$nEH?> H1 {
    margin-bottom: 10px;

}
.<?=$nEH?>-links-block {
    margin-top: 25px;
}

.<?=$nEH?>-links-block LI {
    margin-bottom: 5px;
    padding: 2px;
}

.<?=$nEH?>-links-block .link {
    color: <?=_cssKot('warn-border')?>;
}