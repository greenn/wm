<?
$Self = _kot::self();
$nLS = $Self::nc('LS'); //lay-section
$Self::req_css(-1, 'lay/lays');

?>
<section class="<?=$nLS?>">
    <div fxr class="<?=$nLS?>-headline-w" v-if="hasHeadline" :class="{ 'no-content': !hasContent }">
        <div v-if="$slots.modal || modal">
            <template v-if="$slots.modal">
                <slot name="modal"></slot>
            </template>
            <template v-else>
                <i class="material-icons">more_vert</i>
                <?//{{ modal }} metro-targets/r/table-listing/modal-tpl_messagings.vue.js.inc?>
            </template>
        </div>

        <div fg v-if="$slots.headline || headline">
            <template v-if="$slots.headline">
                <slot name="headline"></slot>
            </template>
            <template v-else>
                {{ headline }}
            </template>
        </div>

        <div v-if="$slots.cmd || cmd">
            <template v-if="$slots.cmd">
                <slot name="cmd"></slot>
            </template>
            <template v-else>
                {{ cmd }}
            </template>
        </div>
    </div>

    <?//fxr: {{ fxr }}?>

    <div class="<?=$nLS?>-content">

        <template v-if="$slots.default">
            <slot></slot>
        </template>
        <template v-else>
            {{ content }}
        </template>
    </div>
</section>