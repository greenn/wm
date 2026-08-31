<?// cmdDb ?>
cmdDb['o'] = {
    buttonTitle: ['click: Убрать границы', 'click: Показать границы'],
    method: function(state){
        this.$par[state? 'addClass' : 'removeClass']('-o');
    },
}