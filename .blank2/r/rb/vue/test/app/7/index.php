<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'qtpl.class',
    'dirUrl'
);
$selfDir = dirname(__FILE__);

$baseUri = dirUrl();
dx($baseUri);

?>
<head>
    <title>App with VueRoot</title>

    <? include '../js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }

    </script>

    <script>
        _vue.nohashRouter = true;
        if (_vue.nohashRouter) {
            _vue.baseUri = '<?=$baseUri?>';
        }


        const Root = VueRoot;
        var _log = Log.for('DBG');
        Root.init(function(_log){
            return {
                _vue: {
                    provide: [
                        //'regField', 'regButton',
                        'link', 'linkBack',
                    ]
                }
            }
        }, true, function(){
            //routes ()

            var Login = this.getComponent('login');
            var Dashboard = this.getComponent('dashboard');

            return [

                { path: '/dashboard', component: Dashboard },
                { path: '/login', component: Login },
                { path: '/:page(.*)*', component: {
                    template: '404 error ({{ $route.fullPath }}) <pre>{{ $route }}</pre>'
                }},
            ];
        }, function(){
            //on mount
        });


    </script>


	<?=qtpl::vue_html("$selfDir/app") ?>
	<?=qtpl::vue_html("$selfDir/login") ?>
	<?=qtpl::vue_html("$selfDir/dashboard") ?>
	<?=qtpl::vue_html("$selfDir/panel") ?>

    <style type="text/css">
        <? include 'app.css.inc' ?>
    </style>

</head>


<body style="background-color: lightpink">
    <app></app>
</body>