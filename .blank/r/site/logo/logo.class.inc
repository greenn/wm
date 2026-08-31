<?

_site::reg('logo', array(
	'nc' => array(
		'base' => 'Lg'
	),
));

class site_logo extends site {

	static function splitTitle($string, $nBy = 3) { //GPT4~
		$res = '';

		// Разбиваем строку на массив слов
		$words = preg_split('/\s+/', $string);

		$parts = []; // Массив для хранения групп слов
		$i = 0;

		// Итерируем по массиву слов
		foreach ($words as $word) {
			if (!isset($parts[$i])) {
				$parts[$i] = [];
			}
			$parts[$i][] = $word;

			// Каждые три слова увеличиваем индекс массива
			if (count($parts[$i]) === $nBy) {
				$i++;
			}
		}

		// Оборачиваем каждую группу слов в тег <span>
		foreach ($parts as $index => $part) {
			$res .= '<span part="' . ($index + 1) . '">';
			$res .= implode(' ', $part);
			$res .= '</span>';
		}

		return $res;
	}
}
