<?php
define('GJ_PATH_LOCAL', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gjmain.php');

$page = TPage('Loading HTML from a File');
$page->add(TA('index.php', 'Back to Index'));

$page->load('x_001_page_content.html');
$page->add(HR . TA('showsource.php?filename=' . basename(__FILE__), 'Show source'));
$page->add(HR . TA('showsource.php?filename=x_001_page_content.html&backto=' . basename(__FILE__), 'Show HTML file'));
$page->render();
?>