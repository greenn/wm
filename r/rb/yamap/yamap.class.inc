<?
/*

[широта, долгота]

*/
_rb::reg('yamap', array(
	'nc' => array(
		'base' => 'YM'
	),
));

class rb_yamap extends rb {

	//static function req_js(){}

	static function req($apiKey = true, $reqIndex = -1){
		if (isLocalhost) {
			static::req_v2($apiKey, $reqIndex);
		} else {
			static::req_v3($apiKey, $reqIndex);
		}
	}

	static function req_v2($apiKey = true, $reqIndex = -1){
		if ($apiKey === true) $apiKey = _pro('yamap-key');
		$apiKeyV = _prop($apiKey, 1, _pro('yamap-v'));
		if (!$apiKeyV) $apiKeyV = 2;

		if ($apiKeyV === 2) $apiKeyV = '2.1';
		if ($apiKeyV === 3) $apiKeyV = '3.0';

		if ($apiKey === true) $apiKey = _pro('yamap-key');
		$libSrc = "https://api-maps.yandex.ru/{$apiKeyV}/?apikey={$apiKey}&lang=ru_RU";
		js::req($reqIndex, false, $libSrc, false, false,  /*без qv*/false);
	}
	static function req_v3($apiKey = true, $reqIndex = -1){
		if ($apiKey === true) $apiKey = _pro('yamap-key');
		$libSrc = "https://api-maps.yandex.ru/3.0/?apikey={$apiKey}&lang=ru_RU";
		js::req($reqIndex, false, $libSrc, false, false,  /*без qv*/false);
	}


	static function static(){

		$mapData = [
			'baseUrl' => "https://static-maps.yandex.ru/1.x/",
			'center' => [
				'longitude' => 28.448694,
				'latitude' => 57.807306
			],
			'size' => '1340,436', // Размер карты, как было указано
			'zoom' => 19,
			'layer' => "map",
			'polygon' => [
				'color' => "3b5998F0",
				'fillColor' => "3b5998A0",
				'width' => 3,
				'coordinates' => [
					[28.448672, 57.807295],
					[28.448714, 57.807294],
					[28.448716, 57.807317],
					[28.448672, 57.807317],
					[28.448672, 57.807295]
				]
			]
		];

		$baseUrl = $mapData['baseUrl'];
		$center = "{$mapData['center']['longitude']},{$mapData['center']['latitude']}";
		$size = $mapData['size'];
		$zoom = $mapData['zoom'];
		$layer = $mapData['layer'];
		$polygon = $mapData['polygon'];

		// Координаты полигона
		$polygonCoords = array_map(function($coord) {
			return implode(',', $coord);
		}, $polygon['coordinates']);

		// Полигон в формате для URL
		$polygonString = "pl,{$polygon['color']},{$polygon['width']},{$polygon['fillColor']}," . implode("~", $polygonCoords);

		// Генерация конечного URL
		$mapUrl = "{$baseUrl}?l={$layer}&ll={$center}&size={$size}&z={$zoom}&pl={$polygonString}";

		return $mapUrl;
		# https://static-maps.yandex.ru/1.x/?l=map&ll=28.448694,57.807306&size=1340,436&z=19&pl=pl,3b5998F0,3,3b5998A0,28.448672,57.807295~28.448714,57.807294~28.448716,57.807317~28.448672,57.807317~28.448672,57.807295
	}


	static function static_uri($geocode_pos, $data = array()){
		static $url_start = 'https://static-maps.yandex.ru';
		static $api_v = '1.x';

		# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/input_params-docpage/
		# Размер яндекс-логотипа снизу картинки 58? x 33

		$data = array_replace(array(
			'l' => 'map', /* Перечень слоев, определяющих тип карты:
			    'map' (схема)
				'sat' (спутник)
				'sat,skl' (гибрид)
			*/
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/map_type-docpage/

			'll' => '30.321905,59.92534', //Долгота и широта центра карты в градусах,
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/map_center-docpage/

			'spn' => '0.01,0.01', //Протяженность области показа карты по долготе и широте
			//сколько градусов карты показывать влево и вправо относительно центра
			//1 градус - 111 км
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/map_viewport-docpage/

			'z' => '10', //Уровень масштабирования карты (0-17)
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/map_scale-docpage/

			'size' => '350,240', //Ширина и высота запрашиваемого изображения карты (в пикселах) [def: 450x450]
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/map_size-docpage/

			'scale' => '2.0', //Коэффициент увеличения объектов на карте. Может принимать дробное значение от 1.0 до 4.0.
			//увеличивает картинку, вместе с логотипом Yandex
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/image_scale-docpage/

			'pt' => '', //Содержит описание одной или нескольких меток, которые требуется отобразить на карте.
			//Описание каждой метки содержит ее координаты (долготу и широту), а также сведения о ее внешнем виде (включая стиль, цвет, размер и текст метки). Описания меток перечисляются через тильду (~).
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/markers-docpage/
			//'37.620070,55.753630,pmwtm1'
			//{долгота},{широта},{стиль}{цвет}{размер}{контент}
			//¦flag¦vkgrm¦home¦

			'pl' => '', //Содержит набор описаний геометрических фигур (ломаных и многоугольников), которые требуется отобразить на карте.
			//Описание фигуры содержит координаты ее вершин, а также сведения о цвете и толщине линии и цвете заливки (для многоугольников). Описания фигур перечисляются через тильду (~).
			# https://tech.yandex.ru/maps/doc/staticapi/1.x/dg/concepts/polylines-docpage/
			//'c:ec473fFF,f:00FF00A0,w:5,37.51,55.83,37.67,55.82,37.66,55.74,37.49,55.70,37.51,55.83'
			//'c:ff0000ff,w:3,80peAuGUQQMIUgAAAAAAAAAAAAAQJwAA'
			//c:{цвет линии},w:{толщина},{вершины}
			//c:{цвет линии},f:{цвет заливки},w:{толщина},{вершины}
			//c:RGBA / 8822DDC0



			'lang' => 'ru_RU', //API позволяет отображать карты, локализованные на различных языках с учетом специфики отдельных стран. Например, можно показать карту с надписями на английском языке и обозначить на ней расстояния в милях (инструмент Линейка).
			//language_region: 'ru_RU'
			//  language — двузначный код языка. Указывается в формате ISO 639-1. Задает язык объектов на карте (топонимов, элементов управления).
			//  region — двузначный код страны. Указывается в формате ISO 3166-1. Определяет региональные особенности, например единицу измерения (для обозначения расстояния между объектами или скорости движения по маршруту).

			'key' => '', //Ключ Яндекс.Карт.
		), array( //defaults
			'll' => $geocode_pos,
			'z' => 11,
			'scale' => null,
			'spn' => null,
			'pt' => null,
			'pl' => null,
			'key' => null,
		), $data);

		foreach ($data as $prm => $conf) {
			if (is_array($conf)) {
				$data[$prm] = join(',', $conf);
			}
		}

		//d($data);
		$url = sprintf('%s/%s/?%s', $url_start, $api_v, http_build_query($data));
		return $url;
	}
}
