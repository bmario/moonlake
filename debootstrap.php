<?php

error_reporting(E_ALL);

include "moonlake/moonlake.php";

use de\Moonlake\Controller\DefaultFrontController;
use de\Moonlake\Request\HttpRequest;
use de\Moonlake\Response\HttpResponse;

// use DefaultFrontController to handle the request.
$front = new DefaultFrontController();

// set default Controller to guestbook_Controller
$front->setDefaultController("cms");

// invoke request handling
$front->handleRequest(new HttpRequest(), new HttpResponse());

?>