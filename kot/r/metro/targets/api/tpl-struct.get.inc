<?

$Self = _kot::self();
include_once $Self::path('api/forecast/aggregate.class.inc');

$info = kot_api::get_data_prop('list', 'targets/tpl-info');

$struct = array();
foreach ($info as $tplName => $tpl) {
	list($sectionName, $tplCode) = explode('/', $tplName);

	$sectionData = targets_aggregate::${"map_$sectionName"};
	$tplData = $sectionData[$tplCode];

	if (!isset($struct[$sectionName])) {
		$sectionFields = array();
		foreach($sectionData as $_tpl => $_fields) {
			$sectionFields = array_merge($sectionFields, $_fields);
		}
		//d($sectionFields);
		$struct[$sectionName] = array(
			'title' => $tpl['sectionTitle'],
			//'struct' => array_unique($sectionFields),
			'struct' => $sectionFields,
			'targets' => array()
		);
		///dx($sectionFields, $tpl);
	}

	$struct[$sectionName]['targets'][$tplName] = array(
		'title' => $tpl['title'],
		'struct' => $tplData,
	);
	///dx($info, $struct, $tplData, $sectionData);
	////dx($info, $tplName, $sectionName, $tplCode, $tpl);
}

//dx($struct);
return kot_api::response(array(
	'struct' => $struct
));