<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';
req_web('inc/css/pcss.php');

$Self = self_rp();
//$Self::req_js( $Self::relPath(__FILE__, '/waypoints') );

//      waypoints.js
$Web = site_rp('web');
$Web::req_js_index(-5, array('waypoints/4.0.1/jquery.waypoints.min.js'));
//$Web::req_js_index(-5, array('waypoints/4.0.1/infinite.min.js'));
$Web::req_js_index(-5, array('waypoints/4.0.1/inview.min.js'));
//$Web::req_js_index(-5, array('waypoints/4.0.1/sticky.min.js'));



ob_start(); ?>


<style type="text/css">
    .ruler {
        position: fixed; z-index: 1000;
        left: 0; right: 0;
        height: 1px;
        background-color: yellowgreen;
        <?=pcss('user-select', 'none')?>
    }
    .ruler:before {
        font: 16px monospace;
        position: absolute;
        top: -8px;
        color: darkorange;
    }

    <? foreach (array(25, 50, 75) as $pos) { ?>
        .ruler._<?=$pos?> { top: <?=$pos?>%; } .ruler._<?=$pos?>:before { content: '<?=$pos?>%'; }
    <? }?>

	MAIN {
        height: 2000px;
        position: relative
    }

	SECTION, A {
		font: 14px monospace;
		background-color: royalblue;
		border: 5px solid wheat;
		position: absolute;
		display: inline-block;
		padding: 20px;
	}
	A {
		font: 16px monospace;
		border-color: indianred;
		right: 0;
	}

    #pos-center {
        top: 50%;
        left: 1000px;
    }
</style>

<script type="text/javascript">
    $(function(){

        var $jq;

        $jq = $('#pos-<?=$pos = 200?>')
        $jq.waypoint({
            handler: function(direction) {
                console.log('#<?=$pos?>', { this: this, id: this.id });
                //notify(this.element.id + ' hit')
            },

        });






        $jq = $('#pos-<?=$pos = 400?>')
        $jq.waypoint({
            handler: function(direction) {
                console.log('#<?=$pos?>', { this: this, id: this.id });
                //notify(this.element.id + ' hit')
            },
            offset: '<?=$offset = '25%'?>'
        })
        $jq.append($(document.createTextNode(' / offset: <?=$offset?>')))



        $jq = $('#pos-<?=$pos = 600?>')
        $jq.waypoint({
            handler: function(direction) {
                console.log('#<?=$pos?>', { this: this, id: this.id });
                //notify(this.element.id + ' hit')
            },
            offset: '<?=$offset = '50%'?>'
        })
        $jq.append($(document.createTextNode(' / offset: <?=$offset?>')))


        new Waypoint({
            element: $jq = $('#pos-<?=$pos = 800?>'),
            handler: function(direction) {
                console.log('#<?=$pos?>', { this: this, id: this.id });
                //notify(this.element.id + ' hit')
            },
            offset: '<?=$offset = '75%'?>'
        });
        $jq.append($(document.createTextNode(' / offset: <?=$offset?>')))



        $jq = $('#pos-<?=$pos = 1000?>')
        $jq.waypoint({
            handler: function(direction) {
                console.log('#<?=$pos?>', { this: this, id: this.id });
            },
            offset: '<?=$offset = 'bottom-in-view'?>'
        });

        $jq.append($(document.createTextNode(' / offset: <?=$offset?>')))


        //не ддопонял
        //offset не работает
        $jq = $('#pos-<?=$pos = 'center'?>')
        new Waypoint.Inview({
            element: $jq[0],
            handler: function(direction) {
                console.log('#<?=$pos?>', [direction]);
            },
            enter: function(direction) {
                console.log('Enter triggered with direction ' + direction)
            },
            entered: function(direction) {
                console.log('Entered triggered with direction ' + direction)
            },
            exit: function(direction) {
                console.log('Exit triggered with direction ' + direction)
            },
            exited: function(direction) {
                console.log('Exited triggered with direction ' + direction)
            },
            offset: '<?=$offset = '50%'?>'


        })
        $jq.append($(document.createTextNode(' / offset: <?=$offset?>')))

    })


</script>


<main>
    <div class="ruler _25"></div>
    <div class="ruler _50"></div>
    <div class="ruler _75"></div>

	<section id="pos-center">
        #pos-center
    </section>

	<section style="top: <?=$pos = 200?>px" id="<?=$id = "pos-$pos"?>">
		<?="pos $pos".' / #'.$id?>
	</section>

    <section style="top: <?=$pos = 400?>px" id="<?=$id = "pos-$pos"?>">
        <?="pos $pos".' / #'.$id?>
    </section>

    <section style="top: <?=$pos = 600?>px" id="<?=$id = "pos-$pos"?>">
        <?="pos $pos".' / #'.$id?>
    </section>

    <section style="top: <?=$pos = 800?>px" id="<?=$id = "pos-$pos"?>">
        <?="pos $pos".' / #'.$id?>
    </section>

    <section style="top: <?=$pos = 1000?>px" id="<?=$id = "pos-$pos"?>">
        <?="pos $pos".' / #'.$id?>
    </section>


</main>

<?
$html = ob_get_clean();

print rp_tpl('page', 'page', array(
	'body' => $html,
	'webKit' => true,
));