<?
$Self = _site::self();
$Self::req_css('form');
$nFd = $Self::nc('Fd');
?>
<div class="<?=$nFd?>"
    :class="{
        '-focus': isFocused,
        '-process': sendQuery,
    }"
>
    <div fxr fxi="c" class="<?=$nFd?>-c">

        <div iflx o1- class="<?=$nFd?>-label ft-form-label">
            {{ label }}
        </div>

        <div o1- r class="<?=$nFd?>-field">
            <input o2- r type="text" rst="input" class="<?=$nFd?>-input ft-form-input"
               :placeholder="placeholder"
               v-model="inputValue"
               <?//@keyup.enter="applyQuery" //gem?>
               <? if (0) { ?> @input="applyQuery"<? } ?>
               @focus="isFocused = true"
               @blur="isFocused = false"

            />
            <div a wp100 class="<?=$nFd?>-input-border"></div>
        </div>

    </div>

</div>