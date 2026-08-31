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
//vue::req('login-form', $selfName, "$relDir/login-form/cmpt");
?>
    <!-- item template -->
    <script type="text/x-template" id="item-template">
        <li>
            <div
                    :class="{bold: isFolder}"
                    @click="toggle"
                    @dblclick="makeFolder">
                {{ item.name }}
                <span v-if="isFolder">[{{ isOpen ? '-' : '+' }}]</span>
            </div>
            <ul v-show="isOpen" v-if="isFolder">
                <tree-item
                        class="item"
                        v-for="(child, index) in item.children"
                        :key="index"
                        :item="child"
                        @make-folder="$emit('make-folder', $event)"
                        @add-item="$emit('add-item', $event)"
                ></tree-item>
                <li class="add" @click="$emit('add-item', item)">+</li>
            </ul>
        </li>
    </script>

    <p>(You can double click on an item to turn it into a folder.)</p>

    <!-- the demo root element -->
    <ul id="demo">
        <tree-item
                class="item"
                :item="treeData"
                @make-folder="makeFolder"
                @add-item="addItem"
        ></tree-item>
    </ul>



<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
//js::req(false, 'https://unpkg.com/dynamics.js@1.1.5/lib/dynamics.js');

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
