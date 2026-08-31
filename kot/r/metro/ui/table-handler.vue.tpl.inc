<?
$Self = _kot::self();
$nTH = $Self::nc('TH'); //table-handler
$Self::req_css('form');

_kot::req_vue('ui', 'select', array(), 'ui-select');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');


?>
<section fxr="fe" fxi="c" class="<?=$nTH?>">
    <span class="<?=$nTH?>-busy">
        <ui-busy :visible="busy"></ui-busy>
    </span>

    <ui-button e-button>
        <i class="material-icons">settings</i>
    </ui-button>

    <span class="<?=$nTH?>-cell-select">
        <ui-select
            :label="'Записей на странице'"
            :options="perPageStack"
            v-model:value="perPage"
        ></ui-select>
    </span>


    <!--    <span>{{ numStart }} - {{ numEnd }}</span>-->

    <span fxr="fe" fxi="c" class="<?=$nTH?>-inf">
        <span>{{ numStart }}</span>
        <span>-</span>
        <span>{{ numEnd }}</span>
        <span>из</span>
        <span>{{ total }}</span>
    </span>


    <ui-button e-button>
        <i class="material-icons">first_page</i>
    </ui-button>

    <ui-button e-button>
        <i class="material-icons">chevron_left</i>
    </ui-button>

    <ui-button e-button>
        <i class="material-icons">chevron_right</i>
    </ui-button>

    <ui-button e-button>
        <i class="material-icons">last_page</i>
    </ui-button>
</section>