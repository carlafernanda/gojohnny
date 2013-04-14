<?php
define('GJ_PATH_LOCAL', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gjmain.php');

$page = TPage('Some Examples for the go!Johnny PHP Library');
$page->add(TH1('Examples') . TP('See the source code of the following examples too see how to use ' . TStrong('go!Johnny') . ' classes.') . TFileList('.', 'php', 'x_', false, 'ol'));

$page->add(HR . TA('showsource.php?filename=' . basename(__FILE__), 'Show source'));
$page->render();
?>