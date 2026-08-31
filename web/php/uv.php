<?#0.7.2

_needphp('isAssoc');
_needphp('notch');
_needphp('url.class');
_needphp('uv/urlVersion');

/*[eg
	_needphp('uv');
	urlVersion::db_connect(INC.'/uv/sd/tkdyastreb.uv');
	$UV_RES = uv_gen_page(true);
	print $UV_RES;
]*/


    /*[im
        если нет url в базе то
            arg1 = $realVersionAnyway|realVersion|
            arg1 === null // ничего не возвращать / пустую строку
            arg1 === true // запомнить/занести версию, и её возвращать
                //попробыватьпп получить версию, если нет то запомнить с _-впереди от timestamp
            arg1 === false // возвращать каждый раз новую версию
    ]*/

    //q $vType
function uv($url, $vType = true){


    //[td добавить host если его нет]

    $v = '';
    $calc = true;
    if ($calc) {
        $v = urlVersion::match($url, $vType);
    }

    //dx($url, $vType, $v);

    return $v;
}

//возвращает url-строку с добавленной версией через параметр qv
//$vType = UV_CONTENT | UV_ETAG/{t} | UV_RAW | UV_HEADERS
function qv($uri, $qs = false, $vType = false){
    $uv = uv($uri, $vType);
    if ($qs === true) {
        $pageQuery = pageQuery;
        $qs = !empty($pageQuery) ? pageQuery : false;
    }
	//dx($uri, $vType, $uv, pageQuery, urlVersion::$db_path);
	//ds($uri, $vType, $uv, pageQuery, urlVersion::$db_path);

    $uri = url::q_ext($uri, $qs, $uv ? "qv=$uv" : '');
	//d($uri, $qs, $uv ? "qv=$uv" : '');
    return $uri;
}

//возвращает url-строку с добавленной Content-версией
function qvc($uri, $qs = false){
    return qv($uri, $qs, UV_CONTENT);
}

//возвращает url-строку с добавленной Etag-версией
function qve($uri, $qs = false){
    return qv($uri, $qs, UV_ETAG);
}


    //возвращает значение версионного-хеша для url

    /*function vq($uri){
        $relPath = false;
        if (is_file($uri)) $relPath = $uri;
        elseif (is_file(ROOT.ltrim($uri, ''))) $relPath = $uri;
        return $uri;
    }*/


    //url-query
    //function uq(){}



    //версионная uri, возвращает uri с добавленной vq
    //$r->vu() - uri относительно директория с vq
    //function vu($uri){}

//mvd to rb
function uv_gen_page($asHtml = false){
    if ($asHtml) {
        ob_start();
        uv_gen_page(false);
        return ob_get_clean();
    }

    include PHP.'/uv/uv-page.php';
}