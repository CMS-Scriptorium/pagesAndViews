<?php

$files_to_register = array(
	'tool.php'
);

LEPTON_secure::getInstance()->accessFiles( $files_to_register );
