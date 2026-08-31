<?//4a

function parseUrl($string, $component = true){ //dx($string, $component);
    $allComponents = $component === true;
    $namedComponent = is_string($component) || is_numeric($component);

    $fRega = '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/'; # https://regex101.com/r/0M1kX3/7

    preg_match_all($fRega, $string, $urlPart);

    $result = array(
        'protocol' => $urlPart[2][0],
        'source' => $urlPart[4][0],
        'uri' => $urlPart[5][0],
        'arguments' => $urlPart[7][0],
        'hash' => $urlPart[9][0]
    );

    $result['host'] = $result['source']; ## to-parse
    $result['domain'] = $urlPart[1][0] . $urlPart[3][0];

    $result[PHP_URL_SCHEME] = $result['protocol'];
    #$result[PHP_URL_USER];
    #$result[PHP_URL_PASS];
    $result[PHP_URL_HOST] = $result['source'];
    #$result[PHP_URL_PORT];
    $result[PHP_URL_PATH] = $result['uri'];
    $result[PHP_URL_QUERY] = $result['arguments'];
    $result[PHP_URL_FRAGMENT] = $result['hash'];

    $extraParsers = array(
        'tokens' => array('parseTokens', $result['uri']),
        //'rawArguments' => array('parseQuery', $result['arguments'], 0),
        'getArguments' => array('parseQuery', $result['arguments'], 1),
        'getOptions' => array('parseQuery', $result['arguments'], 2),
    );
    $extraParse = array();
    if ($allComponents)
        $extraParse = $extraParsers;
    elseif (is_array($component)) {
        $isParserConfig = !isset($component[0]);
        if ($isParserConfig) //
            $extraParse = $component;
        else foreach ($component as $parserName) if (isset  ($extraParsers[$parserName]))
            $extraParse[$parserName] = $extraParsers[$parserName];
    }
    elseif ($namedComponent && isset($extraParsers[$component]))
        $extraParse[$component] = $extraParsers[$component];

    //dx($component, $extraParse);
    foreach ($extraParse as $componentName => $parseConfig)
        if (is_array($parseConfig))
            $result[$componentName] = call_user_func_array('call_user_func', $parseConfig);
        else
            $result[$componentName] = null;

    return $namedComponent ? (isset($result[$component]) ? $result[$component] : null) : $result;
}
//2
function parseTokens($stringUri = ''){
    $tokens = explode('/', trim($stringUri, '/'));
    return $tokens;
}
//2
function parseQuery($stringQuery = '', $responseType = 2){
    $q1_mRega = '/(?:([^&]*)\&?)/'; # https://regex101.com/r/pnL3NC/3
    preg_match_all($q1_mRega, $stringQuery, $queryParts);
    $rawArgumentsStack = $queryParts[1];
    array_pop($rawArgumentsStack);
    $arguments = array();
    if ($responseType == 1) foreach ($rawArgumentsStack as $index => $queryItem) {
        $arguments[]= explode('=', $queryItem);
    } elseif ($responseType == 2) foreach ($rawArgumentsStack as $index => $queryItem) {
        $argument = explode('=', $queryItem);
        $arguments[$argument[0]] = isset($argument[1]) ? $argument[1] : true;
    } else {
        $arguments = $rawArgumentsStack;
    }
    return $arguments;
}