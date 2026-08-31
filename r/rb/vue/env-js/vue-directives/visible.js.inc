<?// https://v3.ru.vuejs.org/ru/guide/custom-directive.html#%D1%85%D1%83%D0%BA%D0%B8 ?>
_AppDirectives['visible-d'] = {
    mounted(el, binding){
        el.style.visibility = !!binding.value ? 'visible' : 'hidden';
    },
    updated(el, binding) {
        el.style.visibility = !!binding.value ? 'visible' : 'hidden';
    }
}

_AppDirectives['visible'] = {
    calc(el, binding){
        //__log('*visible/calc', { args: arguments });
        el.style.visibility = !!binding.value ? 'visible' : 'hidden';
    },
    // Когда привязанный элемент будет примонтирован в DOM...
    mounted(el, binding) {
        // binding.arg — передаваемый в директиву аргумент: v-pin:[direction]
        // binding.value — передаваемое в директиву значение,

        //__log('*visible/mounted', { el, binding, value: binding.value, self: this });
        //el.style.visibility = !!binding.value ? 'visible' : 'hidden';
        binding.dir.calc(el, binding);
    },
    updated(el, binding) {
        //__log('*visible/updated', { el, binding, value: binding.value });
        binding.dir.calc(el, binding);
    }
}