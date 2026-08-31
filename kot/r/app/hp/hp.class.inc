<?
_needphp(
	'transliterate'
);

_kot::reg('hp', array(
	'nc' => array(
		'base' => 'hp'
	),
));

class kot_hp extends kot {

	static function transliterate($string){
		return transliterate($string);
	}


	static function collect_parent_id($id, $list){
		$res = array();
		$item = prop($list, $id);
		if ($item) {
			$res []= $id; //here: есть элемент, добавляем его id

			$parentId = static::collect_parent_id($item['parent'], $list);
			if ($parentId) { //here: есть ответ, добавляем его к результату
				$res = array_merge($res, $parentId);
			}
		}
		return $res;
	}

	static function collect_id($res, $list, $relId){
		//echo '<pre>', val_export($list), '</pre>';
		//dx($list, json_encode($list), $relId);
		dx($list, $relId);
	}

	static function front_prepapre_data($input, $rules = array()){
		$output = $input;

		$listNames = prop($rules, 'list');
		if (is_array($listNames)) foreach ($listNames as $prop) {
			if (has_prop($input, $prop)) {
				$output[$prop] = static::front_prepapre_list($input[$prop]);
			}
		}

		return $output;
	}

	static $listGlue = ',';
	static function front_prepapre_list($input){
		$output = $input;
		if (is_string($input)) {
			$output = explode(static::$listGlue, $input);
		}
		return $output;
		//return $output ? $output : array();
	}


	//mvd r-metro/hp
	static function date_value_format($date, $format = 'front'){
		static $mapFormat = array(
			'db' => 'Y-m-d H:i:s',
			'js-time' => 'Y-m-d\TH:i',
			'js-date' => 'Y-m-d',
			'front' => 'd.m.Y H:i:s',
			'copy' => 'd/m/Y H:i:s',
		);

		if (is_numeric($date)) { //ak tmp
			$dateTime = new DateTime();
			$dateTime->setTimestamp($date);
		} else {
			$dateTime = new DateTime($date);
		}
		$format = prop($mapFormat, $format, $format);
		return $dateTime->format($format);
	}


	static function namedUrl($title, $addUri = ''){
		static $menuData = array(); //$menuListByTitle
		if (!$menuData) {
			$menuData = kot_api::get_prop('list', 'side-menu/v0/list-by', array('by' => 'name'));
		}
		$item = prop($menuData, $title);
		$resLink = prop($item, 'link');
		if ($addUri) {
			$resLink = rtrim($resLink, '/').'/'.ltrim($addUri , '/');
		}
		return '/'.ltrim($resLink, '/');
	}

}



