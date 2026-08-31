<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('sd');


_sd('user-type')->item_add('developer');


_sd('user-type', 'item_add', 'developer');


$sd = new sd('user-type');



$sd = new sd('users');

$id = $sd->add(array('type', 'email', 'pass'));

$update = $sd->update($id, 'v2');
$remove = $sd->remove($id);

dx($add, $update, $remove);