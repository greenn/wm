<?
$Self = _site::self();
$Self::req_css('search-box');
$nSB = $Self::nc('SB');
?>
<div class="<?=$nSB?>"
    :class="{
        '-focus': isFocused,
        '-process': sendQuery,
    }"
>
    <div fxr fxi="c" class="<?=$nSB?>-c">

        <div r class="<?=$nSB?>-field" ref="search-field">
            <input r type="text" rst="input" class="<?=$nSB?>-input ft-search-input"
               placeholder="Поиск"
               v-model="inputValue"
               <?//@keyup.enter="applyQuery" //gem?>
               <? if (0) { ?> @input="applyQuery"<? } ?>
               @focus="isFocused = true"
               @blur="isFocused = false"

            />
        </div>

        <div iflx cp class="<?=$nSB?>-button-icon" @click="fakeSearch">
            <?=_i::img('search/icon.png')?>
        </div>

    </div>
</div>