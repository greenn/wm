<?php



//0.2

function httpResponse($responseBody){
    header('HTTP/1.1 200 OK', true, 200);
    header('Content-Type: text/html; charset=utf-8');

    print $responseBody;
}


//https://ru.wikipedia.org/wiki/Список_кодов_состояния_HTTP
//https://ru.wikipedia.org/wiki/Список_заголовков_HTTP
//https://www.w3.org/Protocols/HTTP/HTRESP.html
//https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
//http://www.lib.ru/WEBMASTER/rfc2068/section-10.html
//https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
//https://www.iana.org/assignments/message-headers/message-headers.xhtml

//https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Encoding