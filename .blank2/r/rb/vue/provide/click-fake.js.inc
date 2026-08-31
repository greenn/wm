_vue.provider.clickFake = function(e, sr){
    //_log('clickFake', { e1: e.target, e2: e.currentTarget })
    var $node = e && $(e.currentTarget);

    //sr - суб-селектор внутреннего объекта
    if (sr) $node = e ? $(sr, $node) : $(sr);

    $node.addClass('shake-404');
    setTimeout(function(){
        $node.removeClass('shake-404');
    }, 500)
}