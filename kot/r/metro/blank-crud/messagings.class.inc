<?
/*
	messagings
	_Messagings

	api
		http://vmk.loc/api/get/kot/messagings/item?id=30000
		http://vmk.loc/api/get/kot/messagings/list

		http://vmk.loc/api/post/kot/messagings/create?fields[title]=555
		http://vmk.loc/api/post/kot/messagings/copy?id=30000

		http://vmk.loc/api/delete/kot/messagings/item?id=30040

		http://vmk.loc/api/put/kot/messagings/update?id=30000&fields[title]=updated-title

		http://vmk.loc/api/patch/kot/messagings/aproove?id=30000
		http://vmk.loc/api/patch/kot/messagings/reject?id=30000

*/

_kot::reg('messagings', array(
	'nc' => array(
		'base' => 'Mgs'
	),
	'api' => array(
		'tbInfo' => 'db-info',
		'tb' => 'messagings', //tbName
		'item' => 'messagings/item', //apiGetItem //array('item-data', 'messagings/item')
		'create' => 'messagings/create', //array('post', 'messagings/create')
	)
));

class kot_messagings extends kot {

	static function prepare_items_data($datas){
		$list = array();
		foreach ($datas as $data) {
			$list []= static::prepare_item_data($data);
		}
		return $list;
	}

	//подготовливает информацию из базы для фронта
	static function prepare_item_data($data){
		static $date_fields = array('date', 'sent');

		$item = $data;

		foreach ($date_fields as $fieldName) {
			$value = prop($data, $fieldName);
			if ($value) {
				$item[$fieldName] = kot('app', 'date_value_format', $value);
				//$item[$fieldName] = kot('app', 'date_value_format', strtotime($value));
			}
		}

		$item['statusTitle'] = prop($item, 'aprooved') ? 'Согласован' : 'Черновик';
		if (isset($item['sent'])) $item['statusTitle'] = 'Завершена';

		return $item;
	}

	static function _prepare_db_target(&$target, $name = ''){
		return $target;
	}

}
