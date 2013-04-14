<?php
define('GJ_PATH_LOCAL', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'gjmain.php');
$page = TPage("Showing Source for file ");

$page->add(TA('index.php', 'Back to Index'));
if((isset($_REQUEST['filename']))&&(file_exists($_REQUEST['filename']))){
	if (isset($_REQUEST['backto'])){
		$backto = $_REQUEST['backto'];
		}else{
		$backto = $_REQUEST['filename'];
		}
	$page->title .= $_REQUEST['filename'];
	$page->add(' | ' . TA($backto, 'Back to Example'));
	$page->add(TH1($page->title));
	$page->add(TPre(str_replace('<', '&lt;', file_get_contents($_REQUEST['filename']))));
	}
$page->render();

?>