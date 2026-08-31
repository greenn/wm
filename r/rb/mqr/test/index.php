<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();
$nT = $Self::nc('T');

$Self::req_js('test/test-app');
//js::req_name('jquery', 'lodash');

ob_start(); ?>
<?////////////////////////////////////////?>
<?

$list = array(
	array('a', 'А'),
	array('b', 'Б'),
	array('v', 'В'),
)

?>
	<style>
        .<?=$nT?>-section {
			display: none;
		}

        .<?=$nT?>-section.-open {
			display: block;
		}
	</style>

	<div tc pt10>
		<? foreach ($list as $item) {
			list($id, $title) = $item;
		?>
			<button class="<?=$nT?>-menu"
				:class="[{ '-pressed': showTest1['<?=$id?>'] }]"
				@click="showTest1['<?=$id?>'] = !showTest1['<?=$id?>']"
			>
				<?=$title?> ({{ showTest1['<?=$id?>'] }})
			</button>
		<? } ?>
	</div>



<? foreach ($list as $item) {
	list($id, $title) = $item;
?>
	<div class="<?=$nT?>-section" name="<?=$id?>"
		:class="[{ '-open': showTest1['<?=$id?>'] }]"
	>
		<?=$Self::tpl('test/test-1', array('text' => $title))?>
	</div>
<? } ?>

<?////////////////////////////////////////?>
<? $body = ob_get_clean();


print rb_tpl('page', 'page', array(
	'body' => $body,
	'pageTitle' => 'MQR tests',
));