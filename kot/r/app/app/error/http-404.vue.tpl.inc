<?
$Self = _kot::self();
$nEH = $Self::nc('EH'); //http-error
$Self::req_css('kot-app');
?>

<section class="<?=$nEH?> <?=$nEH?>-404">
    <!--<top-cmd></top-cmd>-->
    <h1 class="ft-h1">Страница не найдена</h1>
    <h2 class="ft-h2">({{ $route.fullPath }})</h2>
</section>