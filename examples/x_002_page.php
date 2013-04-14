<?php
define('GJ_PATH_LOCAL', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gjmain.php');

$page = TPage('Loading Text from a MarkDown File');
$page->add(TA('index.php', 'Back to Index'));

$page->load('x_002_page_content.txt');
$page->add(HR . TA('showsource.php?filename=' . basename(__FILE__), 'Show source'));
$page->add(HR . TA('showsource.php?filename=x_002_page_content.txt&backto=' . basename(__FILE__), 'Show text file'));
$page->render();
?>