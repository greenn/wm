<?php
//v0.2
/** Склоняем слова
 */
/*
#rudic('слово', 'окончание_1:есть,нет,давать_кому,винить,доволен,думать_о', 'окончание_1:есть,нет,давать_кому,винить,доволен,думать_о');
rudic('отзыв', '0:,а,у,,ом,е', '0:ы,ов,вам,ы,ами,ах');
fox(cw('в', 'отзыв', '*', 'Fcap'), g('rudic'));
*/


#25 //RU DICTIONARY
g('rudic', array());
/** Добавляет в Словарь Склонений Русское слово
@param - Определяюшее слово
@param - Набор окончаний единственного числа
@param - Набор окончаний множественного числа
 */
function rudic($Word, $cdata1=false, $cdata2=false) {
    $RU = g('rudic'); $ENC = 'UTF-8'; //detect_encoding($word);
    $word = tolower((string)$Word);
    if (!isset($RU[$word])) $RU[$word] = array( undefined=>$word ); // undefined — от всяких запасных случаев, по сути надо убрать это, конечно же и перепроверять вдругих местах ☺
    if ($cdata1) {
        if (is_int(mb_strpos($cdata1, ':'))) {
            list($cut_sym, $ending) = explode(':', $cdata1);
            $cword = (strlen($cut_sym)==0||$cut_sym=='0')? $word : mb_substr($word,0,-$cut_sym,$ENC);
        } else list($cword, $ending) = array(false, $cdata1);
        foreach (explode(',', $ending) as $n=>$case) {
            $RU[$word][cw::$cases[$n]] = $cword? $cword.$case : $case;
        }
    }
    if ($cdata2) {
        if (is_int(mb_strpos($cdata2, ':'))) {
            list($cut_sym, $ending) = explode(':', $cdata2);
            $cword = (strlen($cut_sym)==0||$cut_sym=='0')? $word : mb_substr($word,0,-$cut_sym,$ENC);
        } else list($cword, $ending) = array(false, $cdata2);
        foreach (explode(',', $ending) as $n=>$case) {
            $RU[$word][cw::$cases[$n].'*'] = $cword? $cword.$case : $case;
        }
    }
    return g('rudic', $RU); //зачэм рэтурн?
}
/** Преобразует слово в правильный падеж
@param Код Падежа  или предлог
@param Определяющее слово из Словаря
@params set:
 * - множественное число
преобразования:
down - все строчные буквы
UP - все заглавные буквы
Cap - все слова с Большой буквы
Fcap - первое слово с Большой буквы
 */ #028 //change word, convert word
function cw($Case, $Word) {
    $set = setargs(func_get_args(),2);
    $word = tolower((string)$Word);
    $case = (string)$Case;
    $RU = g('rudic');
    $p = !isset(cw::$pcases[$case])? '' : (is_int($pos=mb_strpos($case,'`'))? mb_substr($case, 0, $pos) : $case).' ';
    $case = @qual(cw::$rcases[$case], cw::$cases[$case], cw::$pcases[$case]);
    if ($case && @is_array($RU[$word])) $word = $p . $RU[$word][$case.($set->{'*'}?'*':'')];
    else $word = val($Word);
    if ($set->down) return tolower($word);
    if ($set->UP) return toupper($word);
    if ($set->Cap) return tocap($word);
    if ($set->Fcap) return tofcap($word);
    return $word;
}


class cw {
    var $DICTIONARY = array();
    static $cases = array( # Иван Рубил Дрова, Варвара Топила Печь
        'Nom',  # Именительный, Номанатив                   Есть .. (Кто? Что?)
        'Gen',  # Родительный, Генитив                      Нет .. (Кого? Чего?)
        'Dat',  # Дательный, Датив                          Давать .. (Кому? Чему?)
        'Acc',  # Винительный, Аккузатив, Аблатив           Винить .. (Кого? Что?)
        'Ins',  # Тварительный, Локатив, Инстументатив      Доволен/Сотворён .. (Кем? Чем?)
        'Pos'   # Предложный, Препозитив                    Думать о .. (О ком? О чём?)
    );
    static $rcases = array(
        'И' => 'Nom', 'N' => 'Nom',
        'Р' => 'Gen', 'G' => 'Gen',
        'Д' => 'Dat', 'D' => 'Dat',
        'В' => 'Acc', 'A' => 'Acc',
        'Т' => 'Ins', 'L' => 'Ins',
        'П' => 'Pos', 'P' => 'Pos'
    );
    static $pcases = array( //Использование предлогов
        'в' => 'Acc', 'в`В' => 'Acc', 'в`П' => 'Pos', //Употребляется в сочетании с объектом в винительном или предложном падеже. [ru.wiktionary.org/wiki/в]
        'к' => 'Dat'
    );
//Добавить в Словарь
    function dic($Data) {}

}


//http://www.foxclub.ru/sol/index.php?act=view&id=571
/*
rudic('отзыв', '0:,а,у,,ом,е', '0:ы,ов,вам,ы,ами,ах');
fox(cw('в', 'отзыв', '*', 'Fcap'), g('rudic'));

rudic('фабрика', 'окончание_1:есть,нет,давать_кому,винить,доволен,думать_о');
rudic('жопа', 'опа,--пы,z*пу,опу-опу,Ж-ой,о главном');
fox(cw('в', 'жопа','Fcap'));
*/


/* БАЗА

rudic('фабрика', '1:,и,е,у,ой,е');
rudic('коллекция', '1:,и,и,ю,ей,и');
rudic('модель', '1:,и,и,,ью,и');
rudic('дверь', '1:,и,е,,ью,е');
rudic('порода', '1:,ы,е,у,ой,е');
rudic('стекло', '1:,а,у,о,ом,е');
rudic('пирог', '0:,а,у,,ом,е', '0:и,ов,ам,и,ами,ах');

rudic('Страница', '1:а,ы,е,у,ей,е', '1:ы,,ам,ы,ами,ах');
rudic('Фотография', '1:я,и,и,ю,ей,и', '1:и,й,ям,и,ями,ях');
rudic('изображение', '1:е,я,ю,е,ем,и', '1:я,й,ям,я,ями,ях');
rudic('отзыв', '0:,а,у,,ом,е', '0:ы,ов,ам,ы,ами,ах');
rudic('Текст', '0:,а,у,,ом,е', '0:ы,ов,ам,ы,ами,ах');
rudic('Фотография', '1:я,и,и,ю,ей,и', '1:и,й,ям,и,ями,ях');
rudic('аннотация', '1:я,и,и,ю,ей,и', '1:и,й,ям,и,ями,ях');
rudic('выражение', '1:е,я,ю,е,ем,и', '1:я,й,ям,я,ями,ах');
rudic('сообщение', '1:е,я,ю,е,ем,и', '1:я,й,ям,я,ями,ах');

cw('Р',$X->Title,'*','Fcap');

*/