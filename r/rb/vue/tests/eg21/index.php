<?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);
$selfName = $Self::cfg('rName');



ob_start();
####################################################
?>

<div id="app">
    <? vue::req('cmpt-button', $selfName, "$relDir/button/cmpt"); ?>
    <? vue::req('cmpt1', $selfName, "$relDir/cmpt1/cmpt"); ?>
    <? vue::req('cmpt2', $selfName, "$relDir/cmpt2/cmpt"); ?>
    <v-button title="кнопка"></v-button>
    <component :is="curCmptName"></component>
</div>

<section style="margin-top: 40px">
    <div>
        <b>outide app</b>
    </div>
    <button name="jq">jq</button>
</section>

<script>
    $(function(){
        var $button = $('BUTTON[name="jq"]');
        $button.click(function(){
            console.log('jq/click', {
                App: App,
                    VButton: VButton,
                    ///'VButton.click': VButton.click,
                    'App.component(\'v-button\')': App.component('v-button'),
                    'App.component(\'VButton\')': App.component('VButton'),
                    //button3: App.$options,
                    //button4: App.VButton,
                    //button5: App.component,
                    ///button6: App.$root,
                    //button7: App.$root.VButton,

                'App.changeCmpt': App.changeCmpt,
            });
            //VButton.click();
        })
    })
</script>

<?=js::html_link($Self::uri("$relDir/app.js.php"))?>

<?###################################################
$body = ob_get_clean();
$Self::req_css("$relDir/styles");

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
