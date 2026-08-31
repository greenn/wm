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

        HTML {
            height: 100%;
            padding-left: 100px;
        }
        BODY {
            margin: 0;
            height: 100%;
            width: 100%;

            background: linear-gradient(45deg, #fff1eb, #ace0f9);

            display: table;

        }
        MAIN {
            background-color: lightgreen;
            height: 100%;
            padding-left: 100px;
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

	<main fxc>
		<div>MAIN DIV</div>
		<section>
			<div id="c1">content</div>
		</section>

	</main>

</body>
</html>

