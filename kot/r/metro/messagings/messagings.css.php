<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

//$oo = gt_on('oo'); //dbg
//$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();
$nL = $Self::nc('L');
$nF = $Self::nc('F');
$nI = $Self::nc('I');
$n_TF = kot('ui', 'nc', 'text-field');

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
<?/*[indent="<?=$nF?>-targets-before"] { height: 25px; }*/?>

.<?=$nF?>-cmd-item {
    margin-left: 10px;
}


<?//                ITEM                    ?>
<?//                LISTING                ?>


.<?=$nI?>-row .<?=$n_TF?>.-mr {
    margin-right: 20px;
}

.<?=$nI?>-id.<?=$n_TF?> {
    width: 100px;
}

<?//                FORM                ?>



@media (max-width: <?=_mq(2)?>px) {}