<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);


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
        const Root = VueRoot;
        var _log = Log.for('DBG');
        Root.init(function(_log){

        }, true, function(){
            //routes ()

            var Login = this.getComponent('login');
            var Dashboard = this.getComponent('dashboard');

            return [
                //{ path: '/:page?/:tail(.*)*', component: _DefCmpt },
                { path: '/dashboard', component: Dashboard },
                { path: '/login', component: Login },
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