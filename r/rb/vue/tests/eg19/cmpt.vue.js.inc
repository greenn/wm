
<? if (0) { ?>
app.component('custom-form', {
    emits: ['inFocus', 'submit']
})
<? } ?>

/*

Обратите внимание
    что входные параметры будут валидироваться
        перед созданием экземпляра компонента,
            поэтому
                свойства экземпляра
                        (например,
                    data,
                    computed
                        и т.д.)
                будут недоступны
                    внутри default
                        или
                    функций validator
.
*/

function Person(firstName, lastName) {
    this.firstName = firstName
    this.lastName = lastName
}

const MyCmpt = {
    template: '#my-cmpt',

    props: {
        //postTitle: Number,
        postTitle: [String, Number],

        // Просто проверка типа (`null` и `undefined` проходят проверку для любого типа)
        propA: Number,

        // Несколько допустимых типов
        propB: [String, Number],
        // Обязательное значение строкового типа
        propC: {
            type: String,
            required: true
        },
        // Число со значением по умолчанию
        propD: {
            type: Number,
            default: 100
        },
        // Объект со значением по умолчанию
        propE: {
            type: Object,
            // Для объектов или массивов значения по умолчанию
            // должны возвращаться из функции
            default() {
                return { message: 'привет' }
            }
        },
        // Пользовательская функция для валидации
        propF: {
            validator(value) {
                // Значение должно соответствовать одной из этих строк
                return ['success', 'warning', 'danger'].includes(value)
            }
        },
        // Функция с значением по умолчанию
        propG: {
            type: Function,
            // В отличие от объекта или массива по умолчанию, это не фабричная функция — это функция, служащая в качестве значения по умолчанию
            default() {
                return 'Функция по умолчанию'
            }
        },

        author: Person,

        status: {
            type: String,
            required: true,

            validator: function validator(value) {
                return ['syncing', 'synced', 'version-conflict', 'error'].includes(value);
            }
        }

    }

};
