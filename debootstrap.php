<?php

error_reporting(E_ALL);

include "library/moonlake/moonlake.php";


// use SimpleFrontController (FC) to handle the request.
$front = new Moonlake_Controller_SimpleFrontController();

// set default Controller to guestbook_Controller
// $front->setDefaultController();

// invoke request handling
$front->handleRequest(new Moonlake_Request_HttpRequest(), new Moonlake_Response_HttpResponse());

?>