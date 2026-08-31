<?#0.1

function fileToArray($path){
    $res = false;

    if (is_file($path)) {
        $res = array();
        $file = fopen($path, "r");
        while(!feof($file)) {
            $line = fgets($file);
            $res []= $line;
        }
        fclose($file);
    }

    return $res;
}
//https://stackoverflow.com/questions/13246597/how-to-read-a-large-file-line-by-line


function arrayToFile($path, $arrayData){
    _needphp('file');
    $fileContent = join($arrayData, PHP_EOL);
    return save_file($path, $fileContent);
}