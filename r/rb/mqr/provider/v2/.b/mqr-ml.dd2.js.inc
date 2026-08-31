
if (item.mqrc.ml) {
    var ml = 0;
    if (hasScale) {
        ml = item.mqrc.ml;
    }
    item.$node.css('margin-left', `${ml}px`);
}


if (item.mqrc.mc) {
    var widthWithoutScrollbar = document.documentElement.clientWidth; //
    var wScaledMax = parseInt(item.$node.css('max-width')) * scale;
    //var w = item.$node.width();

    var ml = Math.floor((widthWithoutScrollbar - wScaledMax) / 2);

    /*
        0.8808 scale

        1460 css
        1400 dev tools info
        1286 окно === css * scale
        16 скролл
        1270 окно - без скролла
        1233 реальный размер / dev tools snap === 1400 * scale
            q откуда 1400 не понятно
                в целом это размер паррента?
        1132 getBoundingClientRect
        37 свободное пространства (по факту)
        18,5 ml
    */
    _log('mc', { hasScale,
        ml,

        /*wParent: item.$wrapper.width(),
        wCss: item.$node.get(0).style.width,
        wMax: item.$node.css('max-width'),
        wStyle: item.$node.get(0).style,*/

        /*W1: W1,
        W2: W2,
        wScroll: W1 - W2,
        diffWidth: diffWidth,
        scale: scale,

        ml1: ml,
        ml2: ml * scale,
        ml3: diffWidth / 2,
        ml4: ml * scale - 60 * scale,

        wSet: limWidth,
        wWin: windowWidth,
        wVal: item.$node.width(),
        wTrue: item.$node.get(0).getBoundingClientRect().width,

        wSize: item.$node.get(0).getBoundingClientRect(),*/

    })

}