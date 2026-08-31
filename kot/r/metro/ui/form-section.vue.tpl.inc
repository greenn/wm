<?
$Self = _kot::self();
$nFS = $Self::nc('form-section');
$Self::req_css('form');

?>
<section class="<?=$nFS?>">
    <h3 class="<?=$nFS?>-headline">
        <slot name="headline"></slot>
    </h3>
    <div class="<?=$nFS?>-content">
        <slot name="content"></slot>
    </div>
</section>