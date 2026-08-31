<?
    $Self = _kot::self()
?>
_vue('top-cmd', function(_log, _cmd){
    return {
        _vue: {
            provide: [
                'linkBack',
                'linkPar',
            ],
        }
    }
})