const DatePicker = {
    template: '#cmpt-tpl',
    created() {
        console.log('cmpt/created', { attrs: this.$attrs }) // { onChange: () => {}  }
    }
}
