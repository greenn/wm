<?php
# http://forum.dklab.ru/viewtopic.php?t=37830
function detect_encoding($string, $pattern_size = 50) {
    $list = array('cp1251', 'utf-8', 'ascii', '855', 'KOI8R', 'ISO-IR-111', 'CP866', 'KOI8U');
    $c = strlen($string);
    if ($c > $pattern_size) {
        $string = substr($string, floor(($c - $pattern_size) /2), $pattern_size);
        $c = $pattern_size;
    }

    $reg1 = '/(\xE0|\xE5|\xE8|\xEE|\xF3|\xFB|\xFD|\xFE|\xFF)/i';
    $reg2 = '/(\xE1|\xE2|\xE3|\xE4|\xE6|\xE7|\xE9|\xEA|\xEB|\xEC|\xED|\xEF|\xF0|\xF1|\xF2|\xF4|\xF5|\xF6|\xF7|\xF8|\xF9|\xFA|\xFC)/i';

    $mk = 10000;
    $enc = 'ascii';
    foreach ($list as $item) {
        $sample1 = @iconv($item, 'cp1251', $string);
        $gl = @preg_match_all($reg1, $sample1, $arr);
        $sl = @preg_match_all($reg2, $sample1, $arr);
        if (!$gl || !$sl) continue;
        $k = abs(3 - ($sl / $gl));
        $k += $c - $gl - $sl;
        if ($k < $mk) {
            $enc = $item;
            $mk = $k;
        }
    }
    return $enc;
}

function hyphen_words($text) {
    #буква (letter)
    $l = '(?:\xd0[\x90-\xbf\x81]|\xd1[\x80-\x8f\x91]  #А-я (все)
           | [a-zA-Z]
           )';
    #гласная (vowel)
    $v = '(?:\xd0[\xb0\xb5\xb8\xbe]|\xd1[\x83\x8b\x8d\x8e\x8f\x91]  #аеиоуыэюяё (гласные)
           | \xd0[\x90\x95\x98\x9e\xa3\xab\xad\xae\xaf\x81]         #АЕИОУЫЭЮЯЁ (гласные)
           | (?i:[aeiouy])
           )';
    #согласная (consonant)
    $c = '(?:\xd0[\xb1-\xb4\xb6\xb7\xba-\xbd\xbf]|\xd1[\x80\x81\x82\x84-\x89]  #бвгджзклмнпрстфхцчшщ (согласные)
           | \xd0[\x91-\x94\x96\x97\x9a-\x9d\x9f-\xa2\xa4-\xa9]                #БВГДЖЗКЛМНПРСТФХЦЧШЩ (согласные)
           | (?i:sh|ch|qu|[bcdfghjklmnpqrstvwxz])
           )';
    #специальные
    $x = '(?:\xd0[\x99\xaa\xac\xb9]|\xd1[\x8a\x8c])';   #ЙЪЬйъь (специальные)
    /*
    #алгоpитм П.Хpистова в модификации Дымченко и Ваpсанофьева
    $rules = array(
        # $1       $2
        "/($x)     ($l$l)/sx",
        "/($v)     ($v$l)/sx",
        "/($v$c)   ($c$v)/sx",
        "/($c$v)   ($c$v)/sx",
        "/($v$c)   ($c$c$v)/sx",
        "/($v$c$c) ($c$c$v)/sx"
    );
    */
    #improved rules by D. Koteroff
    $rules = array(
        # $1       $2
        "/($x)     ($l$l)/sx",
        "/($v$c$c) ($c$c$v)/sx",
        "/($v$c$c) ($c$v)/sx",
        "/($v$c)   ($c$c$v)/sx",
        "/($c$v)   ($c$v)/sx",
        "/($v$c)   ($c$v)/sx",
        "/($c$v)   ($v$l)/sx",
    );
    #\xc2\xad = &shy;
    return preg_replace($rules, "$1\xc2\xad$2", $text);
}

//Detecting utf-8, windows-1251
function get_encoding($str){
    $cp_list = array('utf-8', 'windows-1251');
    foreach ($cp_list as $k=>$codepage){
        if (md5($str) === md5(iconv($codepage, $codepage, $str))){
            return $codepage;
        }
    }
    return null;
}

// echo rus2translit('Преобразовывает строку в транслит');
//выводит: Preobrazovyvaet stroku v translit
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v', 'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z', 'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n', 'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u', 'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch', 'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V', 'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z', 'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N', 'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U', 'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch', 'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}



//-
//preg_replace('~[A-Z]~', ' $0', $text_tp_use
//preg_replace('~[А-Я]~', ' $0', $text_tp_use
function isUpperCase($char) {
    if(ord($char)>64 && ord($char)<91) return true;
    elseif(ord($char)>96 && ord($char)<123) return false;
    else return 'Non Alpha Character';
}

//'drwxr-xr-x' => 755
function str2chmod($permissions) {
    $mode = 0;
    if ($permissions[1] == 'r') $mode += 0400;
    if ($permissions[2] == 'w') $mode += 0200;
    if ($permissions[3] == 'x') $mode += 0100;
    else if ($permissions[3] == 's') $mode += 04100;
    else if ($permissions[3] == 'S') $mode += 04000;

    if ($permissions[4] == 'r') $mode += 040;
    if ($permissions[5] == 'w') $mode += 020;
    if ($permissions[6] == 'x') $mode += 010;
    else if ($permissions[6] == 's') $mode += 02010;
    else if ($permissions[6] == 'S') $mode += 02000;

    if ($permissions[7] == 'r') $mode += 04;
    if ($permissions[8] == 'w') $mode += 02;
    if ($permissions[9] == 'x') $mode += 01;
    else if ($permissions[9] == 't') $mode += 01001;
    else if ($permissions[9] == 'T') $mode += 01000;

    return base_convert($mode,10, 8);
}

//fox(perms2chmod(fileperms(__DIR__)));
function perms2chmod($perms) {
    if (($perms & 0xC000) == 0xC000) {
        // Socket
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {
        // Regular
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {
        // Block special
        $info = 'b';
    } elseif (($perms & 0x4000) == 0x4000) {
        // Directory
        $info = 'd';
    } elseif (($perms & 0x2000) == 0x2000) {
        // Character special
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe
        $info = 'p';
    } else {
        // Unknown
        $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x' ) :
        (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x' ) :
        (($perms & 0x0400) ? 'S' : '-'));

    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x' ) :
        (($perms & 0x0200) ? 'T' : '-'));

    return str2chmod($info);
}



/*****************************************************************
This approach uses detection of NUL (chr(00)) and end line (chr(13))
to decide where the text is:
- divide the file contents up by chr(13)
- reject any slices containing a NUL
- stitch the rest together again
- clean up with a regular expression
 *****************************************************************/
//this works with vs < office 2007 and its pure PHP, no COM crap, still trying to figure 200
function parseWord($userDoc)
{
    $fileHandle = fopen($userDoc, "r");
    $line = @fread($fileHandle, filesize($userDoc));
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
    {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
        {
        } else {
            $outtext .= $thisline." ";
        }
    }
    $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
    return $outtext;
}

//$userDoc = "cv.doc";
//$text = parseWord($userDoc);
//echo $text;

/*



$utf8string = "cakeæøå";

        echo substr($utf8string,0,5);
        // output cake#
        echo mb_substr($utf8string,0,5,'UTF-8');
        //output cakeæ



utf8_encode(substr(utf8_decode($string),0,14))



# http://www.php.net/manual/ru/function.substr.php#103843
$utf8marker=chr(128);
$count=0;
while(isset($string{$count})){
    if($string{$count}>=$utf8marker) {
        $parsechar=substr($string,$count,2);
        $count+=2;
    } else {
        $parsechar=$string{$count};
        $count++;
    }
    echo $parsechar."<BR>\r\n"; //do what you like with parsechar ... , eg.
}

*/