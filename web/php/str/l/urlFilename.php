<?#1.1.0

function urlFilename($string){
    return preg_replace(
        array(
            '~(https?)://~',
            '~[/\\\\]~',
            '~[?]~',
            '~[=]~',
            '~[<>:"|?*]~',
            '~[^-=_. \p{L}\p{N}]~' # '~[\x00-\x1F]~' # '~[[:cntrl:]]~' # '~\p{Cc}~'
        ),
        array(
            '$1 ',
            ' - ',
            ' -- ',
            ' = ',
            '_',
            '%',
        ),
        $string
    );
}


/*

$name = str_replace(
    array('/', '\\', '.'),
    array('_', '_', ''),
    $string
);


*/
