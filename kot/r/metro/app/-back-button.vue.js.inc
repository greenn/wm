<?
    $Self = _kot::self()
?>
_vue('back-button', function(_log, _cmd){
    return {
        _vue: {
            provide: [
                'linkBack',
            ],
        }
    }
})