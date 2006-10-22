<?php

// TODO, is this needed...?
// is this global...? what if we include this files
// from a function...?
global $astman;

// remove all Call Waiting options in effect on extensions
if ($astman) {
	$astman->database_deltree('CW');
} else {
	fatal("Cannot connect to Asterisk Manager with ".$amp_conf["AMPMGRUSER"]."/".$amp_conf["AMPMGRPASS"]);
}

?>
