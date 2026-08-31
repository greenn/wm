//underScale, diffWidth
//resWidth, limWidth

function use_mqrw(item){
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