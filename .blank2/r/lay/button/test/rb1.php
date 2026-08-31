<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _lay::self();

site('css', 'req_css', 'ft');

ob_start(); ?>
<?////////////////////////////////////////?>

<style>
	BODY[dark] {
		background-color: #003549;
	}
</style>
<?=$Self::tpl('r-button-1', array(
	//'text' => 'r-button-1'
))?>



<?////////////////////////////////////////?>
<? $body = ob_get_clean();


print rb_tpl('page', 'page', array(
	'body' => $body,
	'a_body' => array(
        'dark' => gt_on('dark', null)
    ),
	'pageTitle' => 'RB1 / Buttons / Lay',
));