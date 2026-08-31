<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

dx(mc::table_delete('table-1'));


d(mc::db_current(false), mc::table_all());
exit;

//$res = mc::query("INSERT INTO `sd-1` (`value`) VALUES ('dd');");
//dx($res, mc::error());
//exit;

//mc::table_delete('table-1');

mc::table_create('table-1', array(
	'id' => array('auto-id', 'int-3'),
	'field' => '',
	//'field' => 'str-1',
));
//exit;
mc::item_add('table-1', array('field' => '11'));

$delete = mc::item_delete('table-1', array('id' => 2));

dx($delete, mc::get_all('table-1'), mc::error());

//sd::add('table-1', '11'); //для типа: base
//sd::add('table-1', array('11')); //для типа: base
//sd::add('table-1', array('field' => '11'));


//_needphp('_h.class');
$sql = "CREATE TABLE persons(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE
)";

$res = mc::query($sql);
dx($res, mc::error());
