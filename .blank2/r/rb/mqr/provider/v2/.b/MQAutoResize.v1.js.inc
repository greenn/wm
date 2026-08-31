__mqr.methods.MQAutoResize = function(){
    var self = this;

    //_log('MQAutoResize', { mqList: _cc(this.mqList) });

    _.each(this.mqList, function(item){
        var limWidth = 0 + item.limW;
        var itemH = item.itemH;
        var mqrs = item.mqrc.s || 0;
        var mqrw = item.mqrc.w || 0;

        ///limWidth += mqrs * 2;

        var windowWidth = window.innerWidth;
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


        if (mqrs) {
            var _mqrs = item.mqrs || {}
            //используется для равномерного съедания левого пространства
            //при наличии у парента side-padding

            mqrs = self.splitValueAndUnit(mqrs);
            if (_mqrs.mq) {
                //ищем изменившееся (из-за MQ) значения
                var mqMin = 0;
                _.forEach(_.sortBy(_.keys(_mqrs.mq)), function(mqVal) {
                    if (windowWidth > mqMin && windowWidth <= mqVal) {
                        mqrs = _mqrs.mq[mqVal]
                    }
                    mqMin = mqVal;
                });
            }

            var range = [0, mqrs[0] * 2];
            if (mqrs[1] === 'vw') {
                range[1] = windowWidth * mqrs[0] * 2 / 100; // vw% от windowWidth
            }

            var newVal = underScale ? Math.ceil(-range[1] / 2) : 0;

            if (_.inRange(diffWidth, range[0], range[1])) {
                newVal = Math.ceil((diffWidth - range[1]) / 2);
            }

            setCss['margin-left'] = newVal + 'px';
            //_log(`mqrs`, { newVal, mqrs, diffWidth, windowWidth, limWidth })
        }


        if (mqrw) {
            var _mqrw = item.mqrw || 0;


            var offBeforeVal = -150;
            //var offBefore = underScale && (diffWidth + offBeforeVal) < 0; //уменьшено меньше чем на 150
            //var offBefore =

            if (_mqrw.before) {

                var mqrwRangeBefore = [0, _mqrw.before];
                var mqrwValBefore = 0;
                //mqrwValBefore = 0; //W > limWidth + _mqrw.before;
                if (diffWidth < mqrwRangeBefore[1]) {
                    mqrwValBefore = mqrwRangeBefore[1] - diffWidth;

                    if (mqrwValBefore > mqrwRangeBefore[1]) {
                        mqrwValBefore = mqrwRangeBefore[1];
                    }
                }

                //debugger;
                resWidth -= mqrwValBefore; //dbg
                limWidth -= mqrwValBefore;

                //_log(`mqrw-before`, { mqrwValBefore, diffWidth, before: _mqrw.before, limWidth, windowWidth })


                if (underScale) {
                    //начинаем возвращать Обратно! то что отняли Before

                    if (_.inRange(diffWidthAbs, mqrwRangeBefore[0], mqrwRangeBefore[1])) {
                        mqrwValBefore = diffWidthAbs;
                    }

                    //_log(`mqrw-offBefore`, { underScale, mqrwValBefore, diffWidth, before: _mqrw.before, mqrwRangeBefore});

                    limWidth += mqrwValBefore;
                }

            }

            if (underScale) {
                var mqrwRange = [0, -mqrw];
                var mqrwVal = mqrwRange[1]
                if (_.inRange(diffWidth, mqrwRange[0], mqrwRange[1])) {
                    mqrwVal = diffWidth;
                }

                resWidth += mqrwVal; //mqrwVal - отрицательный
                limWidth -= Math.abs(mqrwVal);
                //_log(`mqrw`, { mqrwVal, diffWidth, limWidth, mqrwRange, mqrw });
            }

        }

        item.$node.css(setCss)

        var calcHeight = item.$node.height(); //calcedHeight
        var itemHeight = itemH || calcHeight;


        //debouncedLog('mqResize', { hasScale, calcHeight, itemH, limWidth });

        if (item.opts.dbg) {
            item.log('MQAutoResize', { hasScale, diffWidth, calcHeight, itemH, limWidth, curWidth: windowWidth })
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

        item.$wrapper.css({
            //outline: '1px solid green',
            //width: limWidth * scale + 'px',
            //height: itemHeight * scale + 'px',
            width: resWidth + 'px',
            height: resHeight + 'px',
        })

        item.$node.css({
            //position: hasScale ? 'absolute' : item.defPosition,
            width: hasScale ? limWidth + 'px' : '100%'
        })
        //dbg-data
        item.$node.attr('scaled', [
            scale.toFixed(4),
            'h:' + [itemH || 'auto', calcHeight].join('|'),
            //`h:${itemH}`
        ].join('/'));
    })
}

