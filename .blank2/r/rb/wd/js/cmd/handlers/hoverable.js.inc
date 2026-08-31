<?// cmdDb ?>
cmdDb['hoverable'] = {
    buttonText: 'h',
    buttonTitle: function(isOn){
        //console.log('handler-hoverable/buttonTitle', { self: this });
        var hoverName = this.name !== 'h' ? this.name + ' ' : ''
        return [
            'state:',
            (isOn ? 'Использовать' : 'Не использовать'),
            'подсветку ' + hoverName + 'при наведении'
        ].join(' ');
    },
    self: {
        nc: '-hoverable',
    },
    method: function(isOn){
        this.$par[isOn? 'addClass' : 'removeClass'](this.nc);
    },
}
