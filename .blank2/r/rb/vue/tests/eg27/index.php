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
    <!-- component template -->
    <script type="text/x-template" id="grid-template">
        <table>
            <thead>
            <tr>
                <th v-for="key in columns"
                    @click="sortBy(key)"
                    :class="{ active: sortKey == key }">
                    {{ capitalize(key) }}
                    <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
              </span>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="entry in filteredHeroes">
                <td v-for="key in columns">
                    {{ entry[key] }}
                </td>
            </tr>
            </tbody>
        </table>
    </script>
    </head>
    <body>
    <!-- demo root element -->
    <div id="demo">
        <form id="search">
            Search <input name="query" v-model="searchQuery" />
        </form>
        <demo-grid
                :heroes="gridData"
                :columns="gridColumns"
                :filter-key="searchQuery"
        >
        </demo-grid>
    </div>


    <?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>

<?###################################################
$body = ob_get_clean();

$Self::req_css("$relDir/styles");
//$Self::req_css("$relDir/app");

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
