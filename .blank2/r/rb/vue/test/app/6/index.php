<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);

$v2 = gt_on('v2');
$v1 = !$v2;
$vAlt = gt_on('alt');

?>
<head>
    <title>App with VueRoot</title>

    <? include '../js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }
    </script>

	<? if ($v1) { ?>
    <script>
        const Root = VueRoot;
        console.log('[v1]');
        Root.init(function(_log){

        }, true);
    </script>
	<? } ?>

	<? if ($v2) { ?>
        <script>
            const Root = VueRoot;
            console.log('[v2]', 'initApp');
            Root.initApp(function(_log){

            }, true);
        </script>
	<? } ?>

	<?=qtpl::vue_html("$selfDir/app") ?>
	<?=qtpl::vue_html("$selfDir/login") ?>
	<?=qtpl::vue_html("$selfDir/dashboard") ?>

	<? if ($v2) { ?>
        <script>
            console.log('[v2]', 'mountApp');
            //$(function(){ Root.mountApp(true); })
            setTimeout(function(){ Root.mountApp(true); })
        </script>
	<? } ?>

	<? if ($vAlt) { ?>
        <script>
            console.log('[v-alt]', 'via vue_app');
            //работает
            vue_app(function(_log){
                return {
                    data: function(){},
                    mounted: function() {}
                }
            }, function(_log){
                App = _App.mount('BODY');
            })
        </script>
    <? } ?>

</head>


<body style="background-color: lightpink">
    <app></app>
</body>