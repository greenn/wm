<?#1.1
//php('arrayRow', array('a' => 1, 'b' => 2, 'c' => '3'), 2); //?= 3
//получает/добавляет значение assoc-массива по номеру вхождения

function arrayRow($array, $num/*, $value*/){  //q0

    if (is_array($array)) {
        $rowIndex = 0;
        foreach ($array as $key => $val)
            if ($rowIndex++ === $num)
                if (func_num_args() == 3) {
                    $array[$key] = func_get_arg(2);
                    return true;
                } else
                    return $array[$key];
    }

    return false;
}

//название: arrayRow | ? arrayIndex [+]