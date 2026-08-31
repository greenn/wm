<?#8.27.4

/*
	//_addphp('dirToArray/dirToArray_set');
	//_addphp('dirToArray/_dirToArray');

	eg
		dirToArray($catalogPath, 0, false);
*/


function dirToArray($pathRequest, $depth = -1, $keepDots = true) {

    $listPath = array();

    $pathDir = realpath($pathRequest);

    if (is_dir($pathDir)) {

        $listNames = scandir($pathDir);

        foreach ($listNames as $index => $name) {
            #- $name = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($name));
            #- $name = mb_convert_encoding($name, "UTF-8", "auto");
            #~ $name = utf8_encode($name);
            #+ $name = iconv("Windows-1251", "UTF-8", $name);

            if ($selfDirectory = $name == '.') {
               if ($keepDots) $listPath[$name] = $pathDir . DIRECTORY_SEPARATOR;
            } elseif ($parentDirectory = $name == '..') {
	            if ($keepDots) $listPath[$name] = dirname($pathDir) . DIRECTORY_SEPARATOR;
            } else {
                $path = $pathDir . DIRECTORY_SEPARATOR . $name;

                if (is_dir($path)) {
                    if ($depth)
                        $listPath[$name] = dirToArray($path, --$depth, $keepDots);
                    else
                        //$listPath[$name . DIRECTORY_SEPARATOR] = $path;
                        $listPath[$name] = $path . DIRECTORY_SEPARATOR;
                } else {
                    $listPath[$name] = $path;
                }
            }

        }

    }

    return $listPath;
}