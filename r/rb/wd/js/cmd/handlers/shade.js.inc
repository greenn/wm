<?// добавляет opacity для view ?>
cmdDb['shade'] = {
    buttonText: 'shd',
    buttonTitle: 'shade priority',
    method: function(isPressed){
        //console.log('shd', isPressed, { self: this, $par: this.$par });

        $(this.$par).css('z-index', isPressed ? 1000 : 1);

        //overhead для #WCOM1
        var $_op = this.$button.siblings('BUTTON[cmd="op"]'); //$cmd_op|$_op
        var o_isPressed = $_op.hasClass('-pressed');
        //console.log('shd-pressed', { shd: isPressed, op: o_isPressed });
        if (isPressed) {
            this.op_isPressedBefore = o_isPressed;
            if (o_isPressed) $_op.trigger('click'); //делаем op unpressed
        } else {
            if (typeof this.op_isPressedBefore !== 'undefined') if (this.op_isPressedBefore) {
                $_op.trigger('click'); //делаем op pressed (из unpressed)
            }
        }
        //--
    },
}