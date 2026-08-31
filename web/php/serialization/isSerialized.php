<?
# https://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized#45815470
function isSerialized($value) {
    return preg_match('^([adObis]:|N;)^', $value);
}

# https://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized#4994515
function is_serial($string) {
    return (@unserialize($string) !== false);
}

# https://stackoverflow.com/questions/1369936/check-to-see-if-a-string-is-serialized#4994628
function is_serialized( $data ) {
    // if it isn't a string, it isn't serialized
    if ( !is_string( $data ) )
        return false;
    $data = trim( $data );
    if ( 'N;' == $data )
        return true;
    if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
        return false;
    switch ( $badions[1] ) {
        case 'a' :
        case 'O' :
        case 's' :
            if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                return true;
            break;
        case 'b' :
        case 'i' :
        case 'd' :
            if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                return true;
            break;
    }
    return false;
}