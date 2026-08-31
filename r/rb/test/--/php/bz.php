<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

need::php('dirToArray.class');
need::php('dirUrl');

$dir = __DIR__.'/bz';
$data = dirToArray::apply(array(
	'path' => $dir,
	'keepDots' => false,
	'depth' => 1,
));
$data = dirToArray::fileList($data);

$dirUrl = dirUrl($dir);
//dx($data, $dirUrl);

?>
<? if (0) { ?><link rel="stylesheet" type="text/css" href="<?=rb('lay', 'uri', 'flex.css.php');?>" /><? } ?>
<link rel="stylesheet" type="text/css" href="<?=rb('page', 'uri', 'css/q.php');?>" />
<style type="text/css">
	BODY {
		background-color: papayawhip;
		font: 20px monospace;
	}
	A {
		color: royalblue;
	}
	[item] {
		padding: 10px;
		margin: 5px;
	}
</style>
<section fxr fxw>
	<?
	foreach ($data as $name => $path) {
		$uri = $dirUrl.'/'.$name;
	?>
		<div item>
			<a href="<?=$uri?>"><?=$name?></a>
		</div>
	<? } ?>
</section>