<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);


?>
<head>
    <title>vue_app_root</title>

    <script>
        console.time("domready");
        console.time("script-page-bottom");
    </script>

    <? include 'js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }
    </script>

    <?= qtpl::vue_html("$selfDir/atext") ?>


    <script>
        const Root = vue_app_root();
        const root_log = vue_app_root.log;
        //const root_log = Log.for('ROOT')

        $(function(){
            //root_log('domready');
            console.timeEnd("domready");
        })



    </script>

	<?= qtpl::vue_html("$selfDir/acontent") ?>

    <script>
        vue_app_root_init(Root)
    </script>

</head>

<body>
    <div class="app" :bind="{ user }">
        <div atext zp3>
            <button @click="atext != atext">atext</button>
            <atext v-if="is('atext')">atext</atext>
            <atext v-if="atext">atext</atext>
        </div>
        <div acontent zp2>
            <acontent>acontent</acontent>
        </div>
        <div account z5>
            <account>account</account>
        </div>
        <div external zp4>
            <external>external</external>
        </div>
        <div error zp1>
            <error>error</error>
        </div>

    </div>
    <script>
        console.timeEnd("script-page-bottom");
        //root_log('script-page-bottom');

        //vue_app_root_init()
    </script>
</body>