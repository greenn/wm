<?#3.1.0

/*
	https://stackoverflow.com/questions/4249432/export-to-csv-via-php

*/
_addphp('file/chmodVal');
_addphp('str/startsWith');

function read_csv($path, $delimiter = ';', $encode = false) {
	if ($encode == true) $encode = 'Windows-1251';

	$table = array();
	$reader = fopen($path, "r");
	while ($buffer = fgetcsv($reader, 0, $delimiter)) {
		$lastNotEmptyCell = 0;
		$row = array();
		foreach ($buffer as $index => $cell) {
			if ($encode) $cell = iconv($encode, "UTF-8", $cell);
			if (!empty($cell)) $lastNotEmptyCell = $index;
			$row []= $cell;
		}
		array_splice($row, $lastNotEmptyCell + 1);
		$table []= $row;
	}
	return $table;
}

function create_csv($path, $data, $delimiter = ';'){ //, $openFlag

	if (!startsWith($path, 'php://')){
		if (!is_dir($dirPath = dirname($path))) {
			mkdir($dirPath, chmodVal(0755), true);
		};
	}

	$file = fopen($path, 'w'); //wb

	foreach ($data as $item) {
		//foreach ($item as $prop) if (is_array($prop)) d($prop);
		fputcsv($file, $item, $delimiter);
	}

	fclose($file);

	//return is_file($path);
}


function output_csv_data_v1($data, $filename = 'csv'){
	header('Content-Type: text/csv');
	header("Content-Disposition: attachment; filename=$filename");

	//ob_start();
	create_csv('php://output', $data);
	//print ob_get_clean();
}

function output_csv_data($data, $filename = 'csv'){

	$now = gmdate("D, d M Y H:i:s");
	//header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	header("Last-Modified: {$now} GMT");

	//header('Content-Type: text/csv');
	//header("Content-Disposition: attachment; filename='$filename'");

	// force download
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");

	// disposition / encoding on response body
	header("Content-Disposition: attachment;filename={$filename}");
	header("Content-Transfer-Encoding: binary");



	//ob_start();
	create_csv('php://output', $data);
	//print ob_get_clean();
}