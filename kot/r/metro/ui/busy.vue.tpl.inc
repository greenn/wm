<?
$Self = _kot::self();
$nBy = $Self::nc('busy');
$Self::req_css('ui');
?>

    <span ib r class="<?=$nBy?>" :class="{ '-visible': visible }">
        <span ib a class="<?=$nBy?>-icon"></span>
    </span>
