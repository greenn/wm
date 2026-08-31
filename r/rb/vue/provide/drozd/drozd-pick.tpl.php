<?
$Self = _rb::self();
//$Self::req_css('drozd');
$_ctx = $Self::tempCtx(array());
?>

<div fxr fxi="c" v-for="lev in makeRange(pickMaxLevel)" :key="lev">
    <template v-if="pickMaxLevel > 1">
        <input h12 type="checkbox" v-model="pickLevelUsage[lev]"  />
    </template>
    <template v-for="(value, key) in pick">
        <button rst="button" m0 p2 fs8 lh8 cp
                :h="pickLevels[key] === lev ? null : ''"
                style="border: 1px solid grey"
                :style="{ borderColor: pickSelected === key ? 'deepskyblue' : pickHovered === key ? 'lightskyblue' : 'grey'}"

                :class="{ '-selected': pickSelected === key }"
                @click="pickSelected = key"
                @mouseover="pickOpt.hover ? pickSelected = key : pickHovered = key"
                @mouseleave="!pickOpt.hover && (pickHovered = null)"
        >
            {{ key }}
            <? if (!1) { ?>
                ({{ pickLevels[key] }}|{{ lev }})
            <? } ?>
        </button>
    </template>
</div>
