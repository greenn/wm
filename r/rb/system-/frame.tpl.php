<?
/*
    output|frame|
*/
_needphp('pcss');
$tr = data_css('tr0');

//_needinc('css/hex-rgb.php');

$Self = self_rp();
$n = $Self::nc();

//$Self::req_css('blank');
$Self::req_js_index(-3, 'system');

$_ctx = $Self::tplCtx(array(
	'filter' => 'msg',
)); //dx($_ctx);

//_msg('kuku', $_SESSION);

$filter = $_ctx['filter'];
$logData = $Self::logData($filter);

?>
<style type="text/css">
    <?// whitesmoke: rgba(245, 245, 245)?>
    <?// lightcoral: rgba(240, 128, 128)?>

    .<?=$n?> {
        position: fixed; z-index: 10000;
        left: 0;
        right: 0;
        bottom: 0;

        height: auto;
        min-height: 4px;
        background-color: rgba(255, 255, 255, 0);
        <?=pcss('transition', "height $tr, background-color $tr")?>

        max-height: 100vh;
        overflow: scroll;
    }

    .<?=$n?>.-collapsed {
        overflow: hidden;

        height: 4px;
    }


    .<?=$n?>.-contain {
        outline: 2px solid rgba(240, 128, 128, .6);
        background-color: rgba(255, 255, 255, .98);
    }

    .<?=$n?>.-contain.-collapsed {
        outline: none;
    }


    .<?=$n?>-board {
        content: '';
        display: block;
        height: 4px;
        background-color: whitesmoke;
        opacity: .3;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        <?=pcss('transition', "opacity $tr, height $tr")?>
    }

    .<?=$n?>.-collapsed:hover,
    .<?=$n?>:hover .<?=$n?>-board {
        height: 20px;
    }

    .<?=$n?>.-contain .<?=$n?>-board {
        background-color: lightcoral;
        opacity: .6;
    }

    .<?=$n?> H4 {
        font: 22px monospace;
        color: black;
        margin: 4px 10px -4px;
    }
</style>

<div class="<?=$n?> <?if (count($logData)) print '-contain'?> -collapsed">
    <? foreach ($logData as $item) { ?>
        <h4><?=$item['msg']?></h4>
        <? call_user_func_array('d', $item['ctx']); ?>
        <br /><br />
    <? } ?>
    <div class="<?=$n?>-board"></div>
</div>

<script type="text/javascript">
    (function(){
        var $pane = $('.<?=$n?>');
        var $board = $('.<?=$n?>-board', $pane);
        $board.click(function(){
            $pane.toggleClass('-collapsed');
        })
    })();
</script>