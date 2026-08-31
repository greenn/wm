

    <main o1 class="<?=$n?>-content sep-h">

        <lay-section class="-half -od s-content" size="titul-1">
            <template v-slot:headline>
                <i class="material-icons">assistant</i>
                Общие сведения
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

        <lay-section class="-half -o2 s-content" size="titul-1"
            :headline="'~headline'"
            :modal="[]"
        >
            block 2
        </lay-section>

    </main>

