<?// добавляет opacity для view
//dd onInit: web/test/html/input/range.php
?>
cmdDb['op'] = {
    //buttonTitle: ['click: ', 'click: Показать границы'],
    buttonTitle: 'opacity для view',
    method: function(isPressed){
        //console.log('op', { this: this })
        $(this.ncView, this.$par).css({
            opacity: isPressed? .4 : 1
        })
    },
}