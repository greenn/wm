<?/*
	удаляем всю базу ☺
	создаём multi-value таблицу
	и работаем с ней
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('sd');
_needphp('pro/idb.class');

inc_tpl(pro::cfg_get('proDir').'/php/secure.inc', array('button-note' => 'Макс. опасно', 'note' => 'Потенциальное удаление базы данных'));
//include pro::cfg_get('proDir').'/php/secure.inc';

die ('опасные действия с базой');

if (1 && 'STEP2') {
	if (1 && 'добавление c новым типом') {
		_sd('users')->add(array('pew2', 'pew2', md5('kkk')));
	}
	exit;
}


//ручной инит хранение sd-info


//получение конфига таблицы
$tbName = 'users';
$db = pro::db_struct();
$_cfg = $db[$tbName];


//_sd('user-type')->add('test1');
if (1 && 'создание') {
	if (1 && 'удаление всей базы ☻') {
		mc::table_delete_all();
		_sd::info_init();
		//step: создание таблицы 'user-type'
		if (1 && 'создание `user-type`') {
			//dx($db['user-type']);

			idb::init_item_struct('user-type', $db['user-type']['struct']);
			//idb::init_cfg_item('user-type', $db['user-type']); //при добавление используеся sd-add, мешается here при дебаге
		}
	}

	$sdStruct = $_cfg['struct'];
	//запускаем простраиваение зависимостей и самой таблицы
	//$sdStruct = array('sd', 'multi-value', $_struct);
	$res = idb::init_item_struct($tbName, $sdStruct);
	d($res, $sdStruct, mc::error());
}

if (1 && 'добавление') {
	_sd('users')->add(array(1, 'pew', md5('kkk')));
}

if (1 && 'получение') {
	$res = _sd('users')->get1_prop('type', array('login' => 'pew'));
	dx($res, mc::last_sql());
}


