//self, underScale, diffWidth
//setCss
function use_mqrs(item){
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

    //setCss['margin-left'] = newVal + 'px';
    setCss['margin-left'] = underScale ? newVal + 'px' : 'auto';

    //_log(`mqrs`, { newVal, mqrs, diffWidth, windowWidth, limWidth })
}