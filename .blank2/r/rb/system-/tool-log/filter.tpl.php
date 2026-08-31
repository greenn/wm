<?
_needphp('url');

$Self = self_rp();
$nTL_F = $Self::nc('tool-log-filter');
$nj = $Self::nj('tool-log');
$njF = $Self::nj('tool-log-filter');

$_ctx = $Self::tplCtx(array(
	'filter' => array(),
)); //dx($_ctx);

$_filter = $_ctx['filter'];

if (!is_array($_filter)) {
	$_filter = is_string($_filter) ? explode(',', $_filter) : array();
}



?>
<div class="<?=$nTL_F?>">
	<?// d(gt('filter')) ?>
    <script type="text/javascript">
        var <?=$njF?> = function(){};

        $(function(){
            var ncPressed = '-pressed';
            var $buttons = $('.<?=$nTL_F?> BUTTON');
            $buttons.click(function(){
                $(this).toggleClass(ncPressed);
            });
			<?=$njF?> = function(){
                var filter = [];
                $buttons.each(function(){
                    var $button = $(this);
                    if ($button.hasClass(ncPressed)) {
                        filter.push($button.text())
                    }
                })


                var url = new URL(location.href);
                url.searchParams.set('filter', filter.join(','));
                location.href = url.toString()
            }
        })
    </script>
    <a href="javascript:<?=$njF?>()">filter:</a>
	<? foreach(array('msg', 'log', 'error') as $type) {
		$ncPressed = in_array($type, $_filter) ? '-pressed' : '';
		?>
        <button class="<?=$ncPressed?>"><?=$type?></button>
	<? } ?>
</div>