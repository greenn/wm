<? if (0) {/*
    опасно использовать атрибут с таким именем an,
        т.к. данный паремтр может использоваться
            при указании имени анимации
*/?>
[an] {
    <?//=pcss('animation-name', 'hvr-bob-float, hvr-bob')?>
    <?//=pcss('animation-duration', $dur)?>
    <?//=pcss('animation-delay', $dly)?>
    <?//=pcss('animation-timing-function', 'ease-out, ease-in-out')?>
    <?//=pcss('animation-iteration-count', 'infinite')?>
    <?//=pcss('animation-fill-mode', 'forwards')?>
    <?//=pcss('animation-direction', 'normal, alternate')?>
}
<? } ?>

[inf] {
    <?=pcssi('animation-iteration-count', 'infinite')?>
}