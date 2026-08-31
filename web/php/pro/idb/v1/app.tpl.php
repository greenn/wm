<?
//dx($_ctx);
include_once ROOT.'/iq/php/source.class.php';
$_ctx = qtpl::ctx(array(
	//'dbName' => '-',
), $_ctx);

?>

<script type="text/javascript" src="<?=qv('/js/jquery/1.12.4/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=qv('/js/w-storage/5.0.0/storage.js')?>"></script>
<?=_qtpl('collapser')?>
<script>
    const App = (function(){


        return {
            store: _storage.namespaceHandler('idb-v1'),
            /*{
                set
                get
                remove
                dbg
                observable
            }*/
        }
    })()
</script>
