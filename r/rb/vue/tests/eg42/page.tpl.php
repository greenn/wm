<?

$Self = _rb::self();
$relDir = $Self::relDir();
$Self::req_css("$relDir/styles");

$selfName = $Self::cfg('rName');
?>
<main>
	<h1>{{ title }}</h1>
	<div v-for="item in list" :ref="setItemRef">
        <div>{{ item.title }}</div>
    </div>
    <button @click="showInfoToConsole">showInfoToConsole</button>
</main>

<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<?/*<script><?=$Self::tpl("$relDir/app", false, 'js.inc')?></script>*/?>

<script>
    var app = Vue.createApp({
	    data(){
	        return {
	            title: '<?="$selfName ".str_replace(array('/', '\\'), '-', $relDir)?>',
                list: _.transform(['a', 'b', 'c'], function(res, val, key){
	                res.push({ title: val + '(' + key + ')' })
                    return res
                }, []),
                itemRefs: []
	        }
	    },
        methods: {
            setItemRef(el) {
                if (el) {
                    this.itemRefs.push(el)
                }
            },
            showInfoToConsole: function(){
                console.log({
                    'this.itemRefs': this.itemRefs,
                    '$(this.itemRefs)': $(this.itemRefs),
                });

            }

        },

        beforeUpdate() {
            this.itemRefs = []
        },
        updated() {
            console.log(this.itemRefs)
        },

    })

    app.mount('MAIN');
</script>
