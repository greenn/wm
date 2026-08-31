<?#0.4.1
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('html', 'utf8', 'nosniff', 'cache-off');
//_needphp('file');
_needinc('uv');


# step 1: сначала выполняем обновление qv-версий
$UV_RES = uv_gen_page(true);

print $UV_RES;