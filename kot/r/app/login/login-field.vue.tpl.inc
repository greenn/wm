<?
$Self = _kot::self();
$nFd = $Self::nc('field');

//_kot::req_vue('ui', 'form/field', array(), 'ui-field');
?>
<div class="<?=$nFd?>" :class="[cssClass]">
    <div class="<?=$nFd?>-c">
        <input rst="input"
            v-model="input"
            @focus="focus = true" @blur="focus = false"
            :placeholder="label"
        />
    </div>
</div>