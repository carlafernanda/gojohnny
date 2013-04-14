<?php
define('GJ_PATH_LOCAL', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gjmain.php');

TPage('A Simple Page', 'With one line of text.')->render();
?>