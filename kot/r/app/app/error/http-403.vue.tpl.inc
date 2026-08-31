<?
$Self = _kot::self();
$nEH = $Self::nc('EH'); //http-error
$Self::req_css('kot-app');
?>

<section class="<?=$nEH?> <?=$nEH?>-403">
    <!--<top-cmd></top-cmd>-->
    <h1 class="ft-h1">Доступ закрыт+</h1>
    <h2 class="ft-h2">({{ $route.fullPath }})</h2>

	<? if (0) { ?>
        <pre>{{ $route }}</pre>
	<? } ?>

	<? if (0) { ?>
        <content-section :title="'Доступные ссылки'" :open="true" class="<?=$nEH?>-links-block">
            <ul rst="li">
                <li v-for="item in links">
                    <a class="link" @click="link(item.link)">{{ item.text }}</a>
                </li>
            </ul>
        </content-section>
	<? } ?>
</section>