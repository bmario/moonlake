<?php

$start = microtime(true);

include("debootstrap.php");

$end = microtime(true);

$time = $end - $start;
echo "<hr>Laufzeit: $time sec.";

?>