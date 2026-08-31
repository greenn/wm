<?#0.3.3

/*
	man
		https://yandex.ru/support/webmaster/supported-schemas/address-organization.html

		itemscope itemtype="http://schema.org/Organization"
		itemprop="openingHours" datetime="Tu,Th 16:00−20:00"

	eg
		$mdOrg = microdata::scope('Organization');
		$mdPhone = microdata::itemprop('telephone', '+7 495 739–70–00');
		$mdOpeningHours = microdata::prop('openingHours', 'Mo-Fr 9:00−21:00')

	dd
		itemprop
			datetime
		itemscope itemtype

*/
class md {}

class microdata {

	static function attr($name, $value = null) {
		$attr = $name;
		if (!is_null($value)) $attr .= "=\"$value\"";
		return $attr;
	}

	static function scope($value = '', $addSchemeUrl = true) {
		if ($addSchemeUrl) $value = "http://schema.org//$value";
		$attr = 'itemscope '.static::attr('itemtype', $value);
		return $attr;
	}

	static function itemprop($value, $content = false, $isScope = false, $isRawScope = false) {
		$attr = static::attr('itemprop', $value);
		if ($content) { //case: добавить дополнительный атрибут (scope / content)
			$add_attr = $isScope ? static::scope($content, !$isRawScope) : static::attr('content', $content);
			$attr .= ' '.$add_attr;
		}
		return $attr;
	}

	static function prop($name, $ctx = '') {
		$res = (array) static::itemprop($name); //d($name, $res[0]);
		$content = $ctx;
		switch ($name) {
			case 'custom': {} break;
			case 'phone': {
				$res[0] = static::itemprop('telephone');
			} break;

			case 'openingHours': {
				if ($ctx) {
					$res []= static::attr('datetime', $ctx); //d(static::attr('datetime', $ctx));
					//$content = false; //не добавлять attr-content
				}
			} break;
		}

		if ($content) {
			$res []= static::attr('content', $content);
		}
		//dx($res);
		return join(' ', $res);
	}
}