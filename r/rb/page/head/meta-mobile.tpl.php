<?
$Self = _rb::self();

$_ctx = $Self::tempCtx(array(

));

/*ak

    $meta = array();


    $meta['viewport'] = array(
        'width' => 'device-width',
        'initial-scale' => '1.0',
    );

    //аналог device-width для IE Mobile или Pocket IE.
    $meta['MobileOptimized'] = 'width';

    //указывает оптимизирована ли страница сайта под мобильные устройства на Palm и Blackberry
    $meta['HandheldFriendly'] = 'true';

    //позволяет странице работать в полноэкранном режиме на Apple
    $meta['mobile-web-app-capable'] = 'yes';

    print meta::html($meta);


    print meta::html(array(
        'viewport' => array(
            'width' => 'device-width',
            'initial-scale' => '1.0',
        ),
        'MobileOptimized' => 'width', //аналог device-width для IE Mobile или Pocket IE.
        'HandheldFriendly' => 'true', //указывает оптимизирована ли страница сайта под мобильные устройства на Palm и Blackberry
        'pple-mobile-web-app-capable' => 'yes', //позволяет странице работать в полноэкранном режиме на Appleb
    ))
    */
?>
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0" />-->
<meta name="MobileOptimized" content="width" /><?//аналог device-width для IE Mobile или Pocket IE.?>
<meta name="HandheldFriendly" content="true" /><?//указывает оптимизирована ли страница сайта под мобильные устройства на Palm и Blackberry?>
<meta name="mobile-web-app-capable" content="yes" /><?//позволяет странице работать в полноэкранном режиме на Apple?>