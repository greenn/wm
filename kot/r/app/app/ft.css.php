<?#6.0.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//_needphp('headers', 'img/i_');

$Self = _site::self();
ob_start();
?>

.ft-kot {

}

<?
print rb_tpl('css', 'ft.css', array(
    'method' => '_cssKot',
	'sections' => array(
		//'base' => false,
    ),

    'css' => ob_get_clean()
));