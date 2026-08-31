
<? if (0) { ?>
app.component('custom-form', {
    emits: ['inFocus', 'submit']
})
<? } ?>
<? if (0) { ?>
app.component('custom-form', {
    emits: {
        // Без валидации
        click: null,

        // Валидация события submit
        submit: ({ email, password }) => {
            if (email && password) {
                return true
            } else {
                console.warn('Некорректные данные для генерации события submit!')
                return false
            }
        }
    },
    methods: {
        submitForm(email, password) {
            this.$emit('submit', { email, password })
        }
    }
})
<? } ?>

const UserName = {
    props: {
        firstName: String,
        lastName: String
    },
    template: `
    <input
      type="text"
      :value="firstName"
      @input="$emit('update:firstName', $event.target.value)">

    <input
      type="text"
      :value="lastName"
      @input="$emit('update:lastName', $event.target.value)">
  `
};
