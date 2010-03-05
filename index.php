<?php

error_reporting(E_ALL);

// include the framework
include "library/moonlake/moonlake.php";

// init framework
Moonlake_Framework::init();

include("myapp.php");

// run frontcontroller
Moonlake_Framework::run(new MyApp());

?>