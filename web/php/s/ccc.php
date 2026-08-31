<?#1.16.1

//q очищение переменной в сессии по имени

if (isset($_GET['ccc'])) {
	_addphp('s/init');
    if (empty($_GET['ccc'])) {
        $_SESSION = array();
    } elseif (isset($_SESSION[$_GET['ccc']])) {
        unset($_SESSION[$_GET['ccc']]);
    }
}
