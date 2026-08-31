
//сложное добавление (но необходимое) название компонента в декларацию (this._name)
if (!decl.data) decl.data = function(){};
var decl_data = decl.data;

decl.data = function(){
    //var data = decl.data() || {};
    var data = decl_data.call(this) || {};

    //_log('oo decl.data');

    data._index = _cmd.curIndex();


    //if !data.hasOwnProperty('_name')
    //хорошобы с подчёркиванием вынестив в L
    if (!data._name) {
        data._name = name; //базовое внутренее имя компонента
        data._name0 = name; //внутренее имя компонента
        if (data._index) {
            data._name = `${data._name}[${data._index}]`;
        }
        data.name0 = data._name0; //базовое внутренее имя компонента
        data.name1 = data._name; //внутреннее имя компонента
        data.name2 = data._index; //внутренний индекс компонента
    }

    //if (!data._index) {}
    //data._index = 0;

    return data;
}