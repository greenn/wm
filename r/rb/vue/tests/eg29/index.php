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
    <div id="demo">
        <h1>Latest Vue.js Commits</h1>
        <template v-for="branch in branches">
            <input
                    type="radio"
                    :id="branch"
                    :value="branch"
                    name="branch"
                    v-model="currentBranch"
            />
            <label :for="branch">{{ branch }}</label>
        </template>
        <p>vuejs/vue@{{ currentBranch }}</p>
        <ul>
            <li v-for="record in commits">
                <a :href="record.html_url" target="_blank" class="commit"
                >{{ record.sha.slice(0, 7) }}</a
                >
                - <span class="message">{{ truncate(record.commit.message) }}</span
                ><br />
                by
                <span class="author"
                ><a :href="record.author.html_url" target="_blank"
                    >{{ record.commit.author.name }}</a
                    ></span
                >
                at
                <span class="date">{{ formatDate(record.commit.author.date) }}</span>
            </li>
        </ul>
    </div>



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
