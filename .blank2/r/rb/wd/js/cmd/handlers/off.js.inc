<?// прячет wd картинку
?>
cmdDb['off'] = {
    buttonTitle: 'hide view',
    method: function(isPressed){
        $(this.ncView, this.$par).css({
            visibility: isPressed? 'hidden' : 'visible'
        })
    },
}