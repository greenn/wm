<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="/r/rb/lay/flex.css.php" />
	<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />
	<script type="text/javascript" src="/js/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="/js/lodash/4.17.21/lodash.min.js"></script>
	<script type="text/javascript">
		$(function(){
		    var $B1 = $('#b1');
            var $content = $('#c1');

            console.log({
                has_b1: $B1.length,
                has_conten: $content.length
            });


            $B1.click(function(){
                var ncPressed = '-pressed';
                var ncResize = '-resized';
                var isPressed = $B1.hasClass(ncPressed);

                isPressed = !isPressed;

                //step: applyState
                $B1[isPressed ? 'addClass' : 'removeClass'](ncPressed);
                $content[isPressed ? 'addClass' : 'removeClass'](ncResize);

            })


		})
	</script>

    <style>


        MAIN {
            background-color: lightgreen;
            height: 100%;

        }
        SECTION {
            height: 100%;
            background-color: palevioletred;
            outline: 2px dashed firebrick;
        }

        BUTTON.-pressed {

        }

        #c1 {
            height: 100px;
            outline: 1px dotted lime;
        }

        #c1.-resized {
            height: 600px;
        }

    </style>

</head>
<body>
	<div a="tr">
		<button id="b1">content toggle size</button>
	</div>

    <div id="wrapper">
        <main fxc>

            <div>MAIN DIV</div>

            <section>
                <div id="c1">content</div>
            </section>

        </main>
    </div>

</body>
</html>

