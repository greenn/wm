<?
$Self = _rt::self();
$relDir = $Self::relDir();

$nC = $Self::nc('content');

$Self::vue_req('v-content', "$relDir/content");

$Self::vue_req('v-view1', "$relDir/views/1/view");
$Self::vue_req('v-view2', "$relDir/views/2/view");
$Self::vue_req('v-view3', "$relDir/views/3/view");


?>
<section class="<?=$nC?>">
    <v-content :route-view="routeCmptName"></v-content>
</section>