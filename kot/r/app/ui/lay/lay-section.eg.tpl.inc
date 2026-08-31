<?
$Self = _kot::self();
$nLS = $Self::nc('LS'); //lay-section
$Self::req_css('lay/lays');

?>
<div fxr>
    <lay-section class="-half -od s-content" size="titul-1">
        <template v-slot:headline>
            <i class="material-icons">assistant</i>
            Общие сведения 8
        </template>
        <template v-slot:cmd>
            cmd
        </template>
        <template v-slot:modal>
            modal
        </template>
        <template v-slot:default>
            content
        </template>
    </lay-section>

    <div class="sep-hw"></div>

    <lay-section class="-half -o2 s-content" size="titul-1"
                 :headline="'~headline'"
                 :modal="[]"
    >
        block 2
    </lay-section>

</div>

<div class="sep-v"></div>

<div fg>
    <lay-section>
        hp100
    </lay-section>
</div>