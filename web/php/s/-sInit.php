<?#
//-
//чё-то мне здесь не нравится
function sInit(){
    // # https://habrahabr.ru/post/124684/
    // короче данный замес, для того, чтобы не стартавать сессию когда она не нужна
    if (
        !empty($_COOKIE[session_name()]) //куки с сессией уже есть
        || //или если
        $_SERVER['REQUEST_METHOD'] == 'POST') //нам отправляют форму, например, с логином и паролем.
    {
        session_id() || session_start();
    }
    ///#
}