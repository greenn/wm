
if (item.mqrc.ml) {
    var ml = 0;
    if (hasScale) {
        ml = item.mqrc.ml;
    }
    item.$node.css('margin-left', `${ml}px`);
}


if (item.mqrc.mc) {
    var ml = 0;
    if (hasScale) {
        var widthWithoutScrollbar = document.documentElement.clientWidth; //
        var wScaledMax = parseInt(item.$node.css('max-width')) * scale;
        //var w = item.$node.width();

        ml = Math.floor((widthWithoutScrollbar - wScaledMax) / 2);
        //if (item.dbg) _log('mc', { ml })
    }

    //item.$node.css('margin-left', `${ml}px`);
    item.$node.css('margin-left', hasScale ? `${ml}px` : 'auto');

}