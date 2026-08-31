<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


$response = mc::query('SHOW DATABASES');
//$rows = $response->fetch_all();
$rows = _mysql::fetch_all($response);
dx($rows);
