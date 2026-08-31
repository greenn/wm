<?
$Self = _rb::self();
$nIfs = $Self::nc('iframes');

$_ctx = $Self::tempCtx(array(
	'list' => array(),
	'fontReduce' => false
));
$list = $_ctx['list'];

$id = $Self::nc('ifs', uniqid());
?>
<style type="text/css">
    #<?=$id?> IFRAME {
        font-size: 10px;
        height: 50%;
        width: 300px;
        float: left;
    }
</style>
<section class="<?=$nIfs?>" id="<?=$id?>">
    <? foreach ($list as $url) { ?>
        <iframe src="<?=$url?>"></iframe>
    <? } ?>
</section>
<? if ($_ctx['fontReduce']) { ?>
    <script src="/js/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $('#<?=$id?> IFRAME').each(function(){
            var frame = this;
            frame.onload = function () {
                var body = frame.contentWindow.document.querySelector('body');
                //body.style.color = 'red';
                body.style.fontSize = '12px';
                //body.style.lineHeight = '20px';
            };
        })
    </script>
<? }  ?>