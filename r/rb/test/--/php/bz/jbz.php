<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('bz');

bz::init(array(
	'jbz' => dirname(__FILE__).'/jbz',
));

bz::create('clients', array(
	'type' => 1,
	'дата рождения' => 1,
	'филиал' => 1,
	'тренер' => 1,
	'домашний адрес' => 1,
	'место учебы' => 1,
	'ГУП' => 1,
	'паспорт спортсмена' => 1,
));
bz::add('clients', array());