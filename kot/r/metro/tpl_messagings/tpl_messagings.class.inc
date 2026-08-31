<?
/*
	tpl_messagings
	_TtpMessagings

	api
		http://vmk.loc/api/get/kot/tpl_messagings/item?id=30000
		http://vmk.loc/api/get/kot/tpl_messagings/list

		http://vmk.loc/api/post/kot/tpl_messagings/create?fields[title]=555
		http://vmk.loc/api/post/kot/tpl_messagings/copy?id=30000

		http://vmk.loc/api/delete/kot/tpl_messagings/item?id=30040

		http://vmk.loc/api/put/kot/tpl_messagings/update?id=30000&fields[title]=updated-title

		http://vmk.loc/api/patch/kot/tpl_messagings/aproove?id=30000
		http://vmk.loc/api/patch/kot/tpl_messagings/reject?id=30000

*/

_kot::reg('tpl_messagings', array(
	//'className' => 'kot_tpl_messagings',
	'nc' => array(
		'base' => 'TMgs'
	),
	'api' => array(
		'tbInfo' => 'db-info',
		'tb' => 'messagings-tpl', //tbName
		'item' => 'tpl_messagings/item', //apiGetItem //array('item-data', 'tpl_messagings/item')
		'create' => 'tpl_messagings/create', //array('post', 'tpl_messagings/create')
	)
));

class kot_tpl_messagings extends kot {

	static function prepare_items_data($datas){
		$list = array();
		foreach ($datas as $data) {
			$list []= static::prepare_item_data($data);
		}
		return $list;
	}

	//подготовливает информацию из базы для фронта
	static function prepare_item_data($data){
		static $date_fields = array('date');

		$item = $data;

		foreach ($date_fields as $fieldName) {
			$value = prop($data, $fieldName);
			if ($value) {
				$item[$fieldName] = kot('app', 'date_value_format', $value);
				//$item[$fieldName] = kot('app', 'date_value_format', strtotime($value));
			}
		}

		$item['statusTitle'] = prop($item, 'aprooved') ? 'На согласовании' : 'Не активен';

		return $item;
	}

	static function _prepare_db_target(&$target, $name = ''){
		return $target;
	}

}
