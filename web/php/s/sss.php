<?#1.18.1

// вывод всей сессии или значение переменной
if (isset($_GET['sss'])) {
	_addphp('s/init');
    if (empty($_GET['sss'])) {
        dx($_SESSION);
    } elseif (isset($_SESSION[$_GET['sss']])) {
        dx($_SESSION[$_GET['sss']]);
    }
}