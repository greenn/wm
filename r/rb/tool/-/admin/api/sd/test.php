<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/admin/tool-admin.class.php';



//dx(_rw::req('tool-admin'));

parse_str('sd=user-type&id=1', $data);
$res = rt_api::request('tool-admin/sd/item', $data, 'get', 'rw');
dx($res);

//_rp::api('user', array('type' => 'sportsman'));