
<? if (0) { ?>
app.component('custom-form', {
    emits: ['inFocus', 'submit']
})
<? } ?>


const UserName = {
    props: {
        firstName: String,
        lastName: String
    },
    template: '#user-name'
};
