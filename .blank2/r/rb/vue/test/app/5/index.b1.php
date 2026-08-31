<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);


?>
<head>
    <title>VueRoot</title>

    <? include 'js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }
    </script>

    <?/*плохо
         вставлять скрипт до
         так как VueRoot ещё не проинициализирован
    */?>
    <?//=qtpl::vue_html("$selfDir/atext") ?>

    <script>

        //const Root = VueRoot.init(true);
        //$(function(){ Root.mount('BODY'); })

        let Root = VueRoot.init(true, true);
        //let Root = VueRoot.init(true, 'BODY');

    </script>

	<?/*
         скрипты вставлять только вне монтируемого node
         так как VueRoot ещё не проинициализирован
    */?>
	<?=qtpl::vue_html("$selfDir/atext") ?>


	<?//= qtpl::vue_html("$selfDir/acontent") ?>

</head>

<body a="10">
    <div class="app">
        <h1 v-html="'Headline'"></h1>
        <h1 v-text="'1'"></h1>
    <?/*
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
    */?>

    </div>
</body>