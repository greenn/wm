<?
$Self = _kot::self();
$n = $Self::nc();

_kot::req_vue('ui', 'tooltip', array(), 'ui-tooltip');
?>
<div>
    <div ib p="10" o1

    >
        2
        <ui-tooltip v-model:show="showTooltip2">tooltip 1</ui-tooltip>
    </div>


    <ui-button>
        Кнопка
        <ui-tooltip
            :text="'tooltip 2'"
            v-model:show="showTooltip2"
            :base="false"
        ></ui-tooltip>
    </ui-button>


    <v-btn @click="showTooltip2 = !showTooltip2">
        toggle
    </v-btn>

    <v-tooltip
            v-model="showTooltip2"
            location="top"
    >
        <template v-slot:activator="{ props }">
            <v-btn
                    icon
                    v-bind="props"
            >
                <v-icon color="grey-lighten-1">

                    mdi-cart
                </v-icon>

            </v-btn>
        </template>
        <span>Programmatic tooltip</span>
    </v-tooltip>

    <div class="d-flex justify-space-around">
        <v-btn>
            Start
            <v-tooltip
                    activator="parent"
                    location="start"
            >Tooltip</v-tooltip>
        </v-btn>

        <v-btn>
            End
            <v-tooltip
                    activator="parent"
                    location="end"
            >Tooltip</v-tooltip>
        </v-btn>

        <v-btn>
            Top
            <v-tooltip
                    activator="parent"
                    location="top"
            >Tooltip</v-tooltip>
        </v-btn>

        <v-btn>
            Bottom
            <v-tooltip
                    activator="parent"
                    location="bottom"
            >Tooltip</v-tooltip>
        </v-btn>
    </div>

</div>