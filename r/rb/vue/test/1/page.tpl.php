<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rt::self();
$relDir = $Self::relDir();


$Self::req_js(-3, "$relDir/page");
$Self::vue_req('v-button', "$relDir/button");
$Self::vue_req('v-output', "$relDir/output");

//$Api = rt('api', 'apiUrl');
//$apiUrl = $Api::apiUrl();
//$apiUrl = hostUrl.'/api';
//$apiUrl = $Api::apiUrl(); # '/api'

?>
<div id="page">
    <v-button @act="sendApi"></v-button>
    <v-output></v-output>
</div>
