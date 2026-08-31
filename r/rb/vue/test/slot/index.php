<?
//https://v3.ru.vuejs.org/ru/guide/component-slots.html

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
//$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
$relDir = $Self::relDir();// d($relDir);

dx($relDir, $Self::relName());

//dx($relDir, $Self::relDir(), $Self::relDir(true, __FILE__));

//$Self::req_vue("$relDir/cmpt", 'v-cmpt');
$Self::vue_req('v-cmpt', "$relDir/cmpt");
$Self::vue_req('v-cmpt2', "$relDir/cmpt2");
$Self::vue_req('v-cmpt3', "$relDir/cmpt3");
$Self::req_css("$relDir/styles");
$Self::req_js("$relDir/app");

ob_start();
####################################################
?>

<v-cmpt></v-cmpt>

<v-cmpt>
    {{ value }}
</v-cmpt>

    <hr />

<v-cmpt2>
<? if (!1) { ?>
    <template v-slot:header>
        <h1>Здесь мог быть заголовок страницы</h1>
    </template>

    <template v-slot:default>
        <p>Параграф для основного контента.</p>
        <p>И ещё один.</p>
    </template>

    <template v-slot:footer>
        <p>Некая контактная информация</p>
    </template>
<? } ?>

<? if (1) { ?>
    <template #header>
        <h1>Здесь мог быть заголовок страницы</h1>
    </template>

    <template #default>
        <p>Параграф для основного контента.</p>
        <p>И ещё один.</p>
    </template>

    <template #footer>
        <p>Некая контактная информация</p>
    </template>
<? } ?>

</v-cmpt2>

<hr />


    <? if (!1) { ?>
        <v-cmpt3>
            <i class="fas fa-check"></i>
            <span class="green">{{ item }}</span>
        </v-cmpt3>
    <? } ?>

<? if (!1) { ?>
    <v-cmpt3>
        <template v-slot:default="slotProps">
            <i class="fas fa-check"></i>
            <span class="green">{{ slotProps.item }}</span>
        </template>
    </v-cmpt3>
<? } ?>

<? if (!1) { ?>
    <v-cmpt3>
        <template v-slot="slotProps">
            <i class="fas fa-check"></i>
            <span class="green">{{ slotProps.item }}</span>
        </template>
    </v-cmpt3>
<? } ?>

<? if (!1) { ?>
    <v-cmpt3 v-slot="{ item }">
        <i class="fas fa-check"></i>
        <span class="green">{{ item }}</span>
    </v-cmpt3>
<? } ?>

<? if (!1) { ?>
    <v-cmpt3 v-slot="{ item: todo }">
        <i class="fas fa-check"></i>
        <span class="green">{{ todo }}</span>
    </v-cmpt3>
<? } ?>

<? if (!1) { ?>
    <v-cmpt3 v-slot="{ item = 'Нет информации' }">
        <i class="fas fa-check"></i>
        <span class="green">{{ item }}</span>
    </v-cmpt3>
<? } ?>

<? if (1) { ?>
    <v-cmpt3 #default="{ item }">
        <i class="fas fa-check"></i>
        <span class="green">{{ item }}</span>
    </v-cmpt3>
<? } ?>
<?###################################################
$body = ob_get_clean();
$body = "<div id=\"app\">$body</div>";


print rb_tpl('page', 'page', array(
	//'body' => $Self::vue_test($body, true),
	'body' => $body,
	'webkit' => array(
		'vue-env',
		'fas',
    ),
));
