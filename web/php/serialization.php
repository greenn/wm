<? # 1-21
define('PHP_SERIALIZED_FALSE_VALUE', serialize(false));

#1-21
function try_unserialize($value) {
    $res = $value;
    if (is_string($value)) {
        $res = @unserialize($value);
        if ($res === false && $value !== PHP_SERIALIZED_FALSE_VALUE) {
            $res = $value;
        }
    }
    return $res;
}


//include PHP.'/serialization/isSerialized.php';