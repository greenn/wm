<?#3.0.1
if (!1) {
	include 'index1.php';
} else {
	include_once $_SERVER['DOCUMENT_ROOT'].'/gss3/iq.inc';

	include cur('routerFile'); //site/router.php
	if (0) site_router::applyHandlerByUri();
}