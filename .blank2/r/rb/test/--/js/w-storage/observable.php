<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

ob_start();
?>
    <style>
        BODY { background-color: lightgoldenrodyellow }
    </style>

    <script>
        $(function(){
            //location.pathname, '<?=pageUri?>'

            var data = _storage.observable([location.pathname, 'data'], 10);
            ko.applyBindings({
                data: data,
                inc: function(){
                    data(data() + 1)
                },
            }, $('SECTION')[0]);
        })
    </script>

    <section>
        <div><b data-bind="text: data"></b></div>
        <div><button data-bind="click: inc">inc</button></div>
    </section>
<?
$body = ob_get_clean();


print rb_tpl('page', 'page', array(
	'pageTitle' => 'wStorage observable',
	'body' => $body,
	'webkit' => array(
		'w-storage',
		'knockout',
		'jquery',
		//'vue-env'
	),
));