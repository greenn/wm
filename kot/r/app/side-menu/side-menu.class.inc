<?
_needphp(
	'fq/_arr'
);

_kot::reg('side-menu', array(
	'className' => 'kot_side_menu',
	'nc' => array(
		'base' => 'SM'
	),
	'api' => array(
		'tb' => 'admin-menu', //tbName
		//'item' => 'messagings/item', //apiGetItem //array('item-data', 'messagings/item')
		//'create' => 'messagings/create', //array('post', 'messagings/create')
	)
));

class kot_side_menu extends kot {

	static function prepare_list($input){
		$output = kot_hp::front_prepapre_data($input, array(
			'list' => array('prm')
		));

		$childList = array();
		foreach ($output as $index => &$item) {
			//step: вычисляем uri
			if (prop($item, 'uri-auto')) {
				$item['uri'] = is_prop($item, 'name') ? $item['name'] : kot_hp::transliterate($item['title']);
				if (!$item['uri']) $item['uri'] = 'menu-'.$item['id'];
			}

			//if (!$item['parent']) $item['parent'] = -1; //dbg
			array_push_key($childList, $item['parent'], $item['id']);
			/*$parenId = $item['parent'];
			$selfId = $item['id'];
			if (!isset($childList[$parenId])) $childList[$parenId] = array();
			$childList[$parenId] []= $selfId;
			d($parenId, $selfId, $childList);*/

		}

		//step: заменем индексы на id
		$output = array_combine(array_column($output, 'id'), $output);

		foreach ($output as &$item) {
			$item['childs'] = prop($childList, $item['id']);

			$item['parents'] = kot_hp::collect_parent_id($item['parent'], $output);
			///$item['parents'] = array(); kot_hp::_add_id_parent($item['parent'], $output, $item['parents']);
		}

		//dx($input, $output);
		return $output;
	}


}
