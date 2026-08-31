<?#0.3
include_once $_SERVER['DOCUMENT_ROOT'].'/app/iq.php';
_needphp('header');
headers('html', 'utf8', 'nosniff', 'cache-off');
_needphp('file');
_needinc('uv');


# step 1: сначала выполняем обновление qv-версий
$UV_RES = uv_gen_page(true);


# step 2: собираем bundle для app
test_start('Сборка app-bundle');

# step 3: выводим данные об bundle
$new_bundle = AB::build();
//$new_bundle = AB::build(true, 'sep'); //er
print test_end();

$prev_bundle = is_file(APP_BUNDLE_PATH) ? file_get_contents(APP_BUNDLE_PATH) : '';
$hasChanges = $new_bundle !== $prev_bundle;

if ($hasChanges) {
    save_file(APP_PREV_BUNDLE_PATH, $prev_bundle);
    save_file(APP_BUNDLE_PATH, $new_bundle);
    d($hasChanges, $new_bundle, $prev_bundle);
} else {
    $noChanges = true;
    $real_prev_bundle = is_file(APP_PREV_BUNDLE_PATH) ? file_get_contents(APP_PREV_BUNDLE_PATH) : '';
    $bundle = $new_bundle;
    d($noChanges, $bundle, $real_prev_bundle);
}

# step 4: выводим данные qv-версий
_needphp('fileUrl');
print fileUrl(APP_BUNDLE_PATH).'<br />';
print fileUrl(APP_PREV_BUNDLE_PATH).'<br />';
print $UV_RES;