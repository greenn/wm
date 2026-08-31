<?

$self_nc = 'tool-log';
$cmpt1 = 'log-list';
$cmpt2 = 'log-live';

$Self = _rw::name($self_nc);
$nAp = $Self::nc('app');

_rb::req_css('lay', 'flex');
css::req('rw', $self_nc, 'app.css.php');
js::req('rw', $self_nc, 'app.js.php');

vue::req('rw', $self_nc, "$cmpt1/$cmpt1", false, $cmpt1);
css::req('rw', $self_nc, "$cmpt1/$cmpt1.css.php");

vue::req('rw', $self_nc, "$cmpt2/$cmpt2", false, $cmpt2);
css::req('rw', $self_nc, "$cmpt2/$cmpt2.css.php");
//$_ctx = $Self::tempCtx(array());


?>
<div id="app" class="<?=$nAp?>">
	<h1>Log</h1>
	<div>
		<section col="list" fl o1>
			<log-list></log-list>
		</section>
		<section col="live" fr o2>
			<log-live></log-live>
		</section>
	</div>
</div>