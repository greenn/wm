<?
/*
    oo
        kot/r-test/icon-mat.tpl.inc

    [icon] {
        font-variation-settings: 'wght' 400;
        font-variation-settings:
            'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 48
        ;
    }

    https://developers.google.com/fonts/docs/material_symbols?hl=ru

    'FILL' Управляет заполнением иконки. Значения варьируются от 0 (нет заливки) до 100 (полная заливка).
    'wght' Управляет толщиной штриха иконки. Значения варьируются от 100 (тонкий) до 700 (жирный).
    'GRAD' Управляет градиентом иконки. Диапазон от -50 до 200.
    'opsz' Оптический размер иконки, обычно изменяется от 20 до 48 пикселей.
        иконки оптимизированы для использования в этом размерном диапазоне.
        font-size влияет на размер иконки в целом,
        opsz в font-variation-settings используется для оптимизации внешнего вида иконки при определенном размере

    'XHGT' изменения высоты (или "растяжения") иконки.

*/
$Self = _kot::self();
$nIM = $Self::nc('IcM'); //icon-mat

$Self::req_css('ui');

$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc')); //'icon-mat' | icon-mato

//$fArgs = '&display=swap';
$fArgs0 = '&display=swap';
$fArgs = '&display=block';

switch ($vueName) {
	case 'icon-mi': {
		$nf = 'material-icons';
		css::req(-1, false, 'https://fonts.googleapis.com/icon?family=Material+Icons'.$fArgs);
	} break;

	case 'icon-mitt': {
		$nf = 'material-icons-two-tone';
		css::req(-1, false, 'https://fonts.googleapis.com/icon?family=Material+Icons+Two+Tone'.$fArgs);
	} break;

	case 'icon-mr': {
		$nf = 'material-symbols-rounded';
		css::req(-1, false, 'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded'.$fArgs);
	} break;

	case 'icon-ms': {
		$nf = 'material-symbols-sharp';
		css::req(-1, false, 'https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp'.$fArgs);
	} break;

	default: case 'icon-m': case 'icon-mat': case 'icon-mo': {
		$nf = 'material-symbols-outlined';
		css::req(-1, false, 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined'.$fArgs);
	} break;
}


//$Self::req_vue('tooltip', array(), 'ui-tooltip');
$Self::req_vue('tooltip');
?>

<span ib icon-w class="<?=$nIM?>"
    @mouseover="isHover = true"
    @mouseleave="isHover = false"
    :class="{
        '-hover': isHover
    }"
>
    <span r icon class="<?=$nf?>"><slot></slot></span>
    <template v-if="tooltip">
        <? if (0) { ?>
            <span>tooltip: {{ tooltip }}</span>
            <span>isHover: {{ isHover }}</span>
        <? } ?>
        <tooltip
            :text="tooltip"
            v-model:show="isHover"
            <? if (0) { //нужна точка применения ?>
                :hover="isHover"
                v-if="tooltip_msg"
                v-model:show="tooltip_msg" <?/*:show="warnTooltip" @update:show="warnTooltip = $event"*/?>
                :hover="tooltip_hover"
            <? } ?>
        ></tooltip>
    </template>
</span>