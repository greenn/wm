<?
//ak vue-tootlip
$Self = _kot::self();
$nTp = $Self::nc('tooltip');
$Self::req_css('ui');

/*
    https://play.vuetifyjs.com/#eNqNVNtO4zAQ/ZVZP+1KOBHLPlWA2D/Yd8KD60yLwbEte3pBVf99x07aJikSRIriuZ05c3GeD+JvCNV2g2Ih7gm7YBXhY+MA7rdSe0fKOIxZBljZjWn7o7YqpYdGEO5JanTEPiKbSmgJjn7Xny/eK4v73i0/b5tEZvXB+hSURrlE2iG6k8OANBCxwG/GuP3diLOpGJfk4Elbo98z1KvfwQP8yN+JIwD59driKLQusZc8LHMSlqeZLxEjCiPlUFxHcmyYciTvLZkwprOVnW/RDpzHiADWa0XGu9xhH8a2SUXngTFYsp4WSpPZKvKRAw8Qog8JjrM2nHo21QEYnvZcx47GtQxWoKYcZ1wG4IyS+1QorCN+SGvWr4RO3l7xyE/XGqlVpCsoHkbGmlOfzazXTfb2rOatco//ol9H1XXcTs0bUKZwXxfTdBMG2yfbcJJ4ofuLUSzDzWDNJD+LSUcTqLjiPvhI0OJKbSzBoQdrFSn4+eskAkSkTXQXGSCvxAJWyia8OWmP/eFYFCxwGX0mcSOsce+pekve8T0uOI3QiSe2gOc+rBGvRCEt6lq3jj159cw2Vg6pdqGr+Q+QL+PTXXVX3f6pW5PopJNWLVNV0DLUS+OOnNF0uTTZqTBL2xtK6qGgRjBSlr/g8MRuddw4Mh3K1neFzMBlpK4wdXLJ00gYGaQRQ4dKmkz4G6m+LJdzXGHXnHCLUUZ0Lcb8x/teSbOwcVkz01Vpw6iP4ngjShh3vucsXv4D7XO5dw==
    https://vuetifyjs.com/en/components/tooltips/#usage
*/
?>

<v-tooltip
    class="<?=$nTp?>"
    activator="parent"
    :location="side || 'bottom'"

    :modelValue="show"
    @update:modelValue="updateValue($event)"
>
    <template v-if="$slots.default">
        <slot></slot>
    </template>
    <template v-else>
        {{ text }}
    </template>
</v-tooltip>
<?/*

activator
    В библиотеке v-tooltip для Vue есть параметр activator, который определяет элемент, на котором будет отображаться подсказка. Значения параметра activator могут быть следующими:

    String: Вы можете указать селектор элемента, на котором будет активироваться подсказка. Например, 'button' активирует подсказку на всех кнопках.

    Element: Вы можете передать прямо элемент, который должен активировать подсказку. Например, document.querySelector('button') выбирает первую кнопку на странице.

    Object: Вам также доступны объекты с различными свойствами, чтобы управлять подсказкой. Например:

    javascript
    Copy code
    activator: {
      event: 'click', // Тип события для активации (например, 'hover', 'click')
      handler: 'customHandler', // Имя события, которое будет прослушиваться
    }
    Вы можете использовать это, чтобы задать свой собственный обработчик события, которое будет активировать подсказку.

    Function: Вы можете передать функцию, которая возвращает элемент-активатор. Например:

    javascript
    Copy code
    activator: () => document.querySelector('.my-activator')
    Это позволяет вам динамически выбирать элемент активации.

    Array: Если вы хотите использовать несколько активаторов, вы можете передать массив из элементов, строк, объектов или функций.

    Special Keywords: null (по умолчанию) и 'target' означают, что активатором будет сам элемент, к которому применяется


*/?>