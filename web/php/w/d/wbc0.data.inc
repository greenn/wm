<?#2.0


$q0 = '0:1,>20/[1]$/;'.'0\а:2,3,4,>20/[234]$/;'.'0\ов:';
    //[td] 'И:1,>20/[1]$/;'.'Р:2,3,4,>20/[234]$/;'.'Р+:',


$zal = array( //https://ru.wiktionary.org/wiki/Викисловарь:Использование_словаря_Зализняка
    '1a' => array('0:,а,у,,ом,е', '0:ы,ов,ам,ы,ами,ах', $q0), //элемент, филиал, отзыв, тренер, спортсмен
    '1c(2)' => array( '0:,а,у,,ом,е', '0:ы,ов,ам,ы,ами,ах', $q0), //раз
    '2е' => array('1:е,я,ю,е,ем,и', '1:я,й,ям,я,ями,ях', $q0), //направление, применение
    '3a' => array('0:,а,у,а,ом,е', '0:и,ов,ам,ов,ами,ах', $q0), //человек, банк
    '3b' => array('0:,а,у,а,ом,е', '0:и,ов,ам,ов,ами,ах', $q0), //поставщик
    '3e' => array('1:ь,и,и,ь,ью,и', '1:и,ей,ям,и,ями,ях', $q0), //отрасль
    '4b' => array('0:,а,у,,ом,е', '0:и,ей,ам,и,ами,ах', $q0), //крепёж
    '6a' => array('1:я,и,е,ю,ей,е', '1:и,й,ям,и,ями,ях', $q0), //галерея
    '7a' => array('1:е,я,ю,е,ем,и', '1:я,й,ям,я,ями,ях', '0:1,>20/[1]$/;'.'1\e:2,3,4,>20/[234]$/;'.'1\й:'), //изменение, достижение, событие
    '8e' => array('1:ь,и,и,ью,и', '1:и,ей,ям,и,ями,ях', $q0), //новость
);

return array( # https://ru.wiktionary.org/wiki/
    'банк' => $zal['3a'], //https://ru.wiktionary.org/wiki/банк
    'галерея' => $zal['6a'], //https://ru.wiktionary.org/wiki/галерея
    'достижение' => $zal['7a'], //https://ru.wiktionary.org/wiki/достижение
    'изменение' => $zal['7a'], //https://ru.wiktionary.org/wiki/изменение
    'контейнер' => $zal['1a'], //https://ru.wiktionary.org/wiki/контейнер
    'клиент' => $zal['1a'], //https://ru.wiktionary.org/wiki/клиент
    'крепёж' => $zal['4b'], //https://ru.wiktionary.org/wiki/крепёж
    'направление' => $zal['2е'], //https://ru.wiktionary.org/wiki/направление
    'новость' => $zal['8e'], //https://ru.wiktionary.org/wiki/новость
    'отзыв' => $zal['1a'], //https://ru.wiktionary.org/wiki/отзыв
    'отрасль' => $zal['3e'], //https://ru.wiktionary.org/wiki/отрасль
    'поставщик' => $zal['3b'], //https://ru.wiktionary.org/wiki/поставщик
    'применение' => $zal['2е'], //https://ru.wiktionary.org/wiki/применение
    'проект' => $zal['1a'], //https://ru.wiktionary.org/wiki/проект
    'событие' => $zal['7a'], //https://ru.wiktionary.org/wiki/событие
    'раз' => $zal['1c(2)'], //https://ru.wiktionary.org/wiki/раз
    'спортсмен' => $zal['1a'], //https://ru.wiktionary.org/wiki/спортсмен
    'текст' => $zal['1a'], //https://ru.wiktionary.org/wiki/текст
    'тренер' => $zal['1a'], //https://ru.wiktionary.org/wiki/тренер
    'филиал' => $zal['1a'], //https://ru.wiktionary.org/wiki/филиал
    'человек' => $zal['3a'], //https://ru.wiktionary.org/wiki/человек
    'элемент' => $zal['1a'], //https://ru.wiktionary.org/wiki/элемент
    'эффект' => $zal['1a'], //https://ru.wiktionary.org/wiki/эффект
);