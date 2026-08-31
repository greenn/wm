decl.mounted = function(){
    //_log('MOUNTED');

    if (this._index) {
        //this.log = Log.for(logName + '.' + this._index);
        this.log = Log.for(logName);
        this.log.index = this._index;
        //this.log.setIndex(this._index);
    }

	<? if ($v < 3) { ?>
        //v1(2) для v3 не используется
        _app.init(name, this); //[pr для повторяющихся компонентов] не будет срабатывать
            //fix ak _cmd.mounted()
            //var _index = _cmd.curIndex(true);
        // if (_index) _log.index = _index;

	<? } ?>

    _mounted && _mounted.apply(this, arguments);

}