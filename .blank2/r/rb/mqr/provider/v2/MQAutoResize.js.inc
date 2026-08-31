__mqr.methods.MQAutoResize = function(logTitle){

    logTitle = 'MQR:' + logTitle;

    var self = this;

    //if(1) _log('MQAutoResize', { mqList: _cc(this.mqList) });



    _.each(this.mqList, function(item){
        var limWidth = +item.limW;
        //_log('limW', { limW: item.limW });
        var itemH = item.itemH;
        var mqrs = item.mqrc.s || 0;
        var mqrw = item.mqrc.w || 0;

        ///limWidth += mqrs * 2;

        //var windowWidth = window.innerWidth;
        var windowWidth = screen.width;
        //windowWidth = item.$node.width();
        var scale = 1;
        var diffWidth = windowWidth - limWidth;
        var diffWidthAbs = Math.abs(diffWidth);
        var underScale = diffWidth < 0;
        if (underScale) { //underScale
            scale = windowWidth / limWidth; //вычисляем k уменьшения
        }
        var hasScale = scale < 1;

        var resWidth = limWidth * scale;


        var setCss = {
            transform: 'scale(' + scale + ')'
            //transform: `scale(${scale})`
        }

		<? include_once 'MQAutoResize/mqrs.js.inc' ?>

		<? include_once 'MQAutoResize/mqrw.js.inc' ?>


        if (mqrs) use_mqrs(item);

        if (mqrw) use_mqrw(mqrw);

        if (item.mqrw) {

            if(0) console.log('mqrw resize', {
                item: _cc(item),
                $node: item.$node
            });

            if (item.mqrw.less) {
                limWidth -= item.mqrw.less
            }
        }

        var mqrh = item.mqrh


        item.$node.css(setCss)

        var calcHeight = item.$node.height(); //calcedHeight
        var itemHeight = itemH || calcHeight;

        if (mqrh) {

            //dd / 01 / пока и так работает
            if(0) if (mqrh.child) {
                var childHeight = 0;
                item.$node.children().each(function() {
                    childHeight += $(this).height();
                });
                if(1) _log('mq-resize/mqrh', {
                    $node: item.$node,
                    $child: item.$node.children(),
                    calcHeight, itemH, childHeight
                });
            }

        }

        //debouncedLog('mqResize', { hasScale, calcHeight, itemH, limWidth });

        if (item.opts.dbg) {
            item.log('MQAutoResize', { dbg: item.opts.dbg, hasScale, diffWidth, calcHeight, itemH, limWidth, curWidth: windowWidth })
        }

        if(0) if (hasScale) {
            item.dbg && _log('MQAutoResize', {
                scale, limWidth, windowWidth, itemHeight, itemH,
                is$node: item.$node.length, is$wrapper: item.$wrapper.length,
                $wrapper: _cc(item.$wrapper),
                item
            });
        }

        resWidth = limWidth * scale;
        var resHeight = itemHeight * scale;


        if(__cfg.dbg()) console.log(logTitle, _cc({
            hasScale,
            resWidth,
            resHeight,
            limWidth,
            itemHeight
        }))

        //debugger;
        item.$wrapper.css({
            //outline: '1px solid green',
            //width: limWidth * scale + 'px',
            //height: itemHeight * scale + 'px',
            width: hasScale ? resWidth + 'px' : '-webkit-fill-available',
            height: hasScale ? resHeight + 'px' : '-webkit-fill-available',
        })

        item.$node.css({
            //position: hasScale ? 'absolute' : item.defPosition,
            width: hasScale ? limWidth + 'px' : '100%'
        })


		<? include_once 'MQAutoResize/mqr-ml.js.inc' ?>

        if (item.mqrl !== undefined) {
            //item.log('::mqrl', item.mqrl);

            var ml = 0;
            if (hasScale) {
                ml = -1 * Math.floor((limWidth - resWidth) / 2);
            }
            item.$node.css('margin-left', hasScale ? `${ml}px` : 'auto');

        }


        //dbg-data
        item.$node.attr('scaled', [
            scale.toFixed(4),
            'h:' + [itemH || 'auto', calcHeight].join('|'),
            //`h:${itemH}`
        ].join('/'));
    })
}

