<?
    $c = isset($arg[1]) ? $arg[1] : '%s';

    if (isset($arg[2])) {
        $name = $arg[1];
        $val = $arg[2];
        $c = '';
        foreach ($val as $point => $values) {
            if (is_array($values)) {
                if (isAssoc($values)) {
                    $s = array();
                    foreach ($values as $prop => $value) {
                        if (!is_null($value))
                            $s []= "$prop: $value";
                    }
                    $values = $s;
                }

                foreach ($values as $p => $v) if (is_null($v)) unset($values[$p]);
                $values = join($values, ";\r\n");
            }

            $c .= sprintf('%s { %s }', $point, $values);
        }
        $c = "$name { $c }";
    }
?>
@-webkit-keyframes <?=$c?> <?# Chrome < 43.0, Safari < 4.0?>
@-moz-keyframes <?=$c?> <?# 5.0 >< 16.0?>
@-o-keyframes <?=$c?> <?# 4.0 >< 12.10?>
@keyframes <?=$c?>