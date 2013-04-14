<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Ara�atuba - SP - Brazil - 2013
*/
////////////////////////////////////////////////
////////////////////////////////////////////////
//error_reporting(E_ALL ^ E_STRICT);
error_reporting(E_ALL & ~E_STRICT);
$serverpath = 'http://' . $_SERVER['HTTP_HOST'];
$gjwebpath = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
$gjwebpath = $serverpath . '/' . $gjwebpath[count($gjwebpath)-1];

foreach(array(
	'br' => '<br>',
	'BR' => '<br>',
	'hr' => '<hr>',
	'HR' => '<hr>',
	'GJ_PATH_LOCAL' => dirname(__FILE__), //internal path to the go!Johnny library; used by php
	'GJ_PATH_WEB' => $gjwebpath, //external path to the go!Johnny library; used by css and javascript
	'GJ_CHARSET' => 'utf-8',
	'GJ_DATEFORMAT' => 'Y-m-d',
	'GJ_TIMEFORMAT' => 'H:i:s',
	'GJ_SENDHEADERS' => true,
	'GJ_USEGJFONTS' => true, //include some nice free fonts
	'GJ_USETIDY' => true,
	'GJ_AUTOCLASS' => false,
	'GJ_AUTOID' => true,
	'GJ_AUTOMAIN' => true,
	'GJ_PAGECONTAINERTYPE' => 'div',
	'GJ_USEMATHML' => false,
	'GJ_SHORTCUTS' => true,
	'GJ_OPENGRAPH_METATAGS' => false,
	'GJ_DEFAULTICON' => '/_gojohnny7/media/gj_32.ico',
	'GJ_DEFAULTFORMMETHOD' => 'POST',
	'GJ_DEFAULTFORMAUTOCOMPLETE' => 'on',
	'GJ_DEFAULTFORMENCTYPE' => 'multipart/form-data',
	'GJ_DEFAULTINPUTTYPE' => 'text',
	/* 
	3rd party libraries
	*/
	'GJ_BASECSS' => "{$gjwebpath}/lib/bootstrap/css/bootstrap.css",
	'GJ_JQUERY' => "{$gjwebpath}/lib/jquery/jquery.js",
	'GJ_JQUERYUI_CSS' => "{$serverpath}/jqueryui/css/ui-lightness/jquery-ui-1.8.17.custom.css",
	'GJ_JQUERYUI_JS' => "{$serverpath}/jqueryui/js/jqueryui.js",
	'GJ_USEGJCSS' => true,
	'GJ_USEGJJS' => true,
	'GJ_MARKDOWN' => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'markdown.php'
	) as $name => $val){
	if(!defined($name)){
		define($name, $val);
		}
	}

////////////////////////////////////////////////
/** Auxiliary functions.
 *  Generic functions which don't fit in any class or which are too generic and suited to several classes.
 *  A function should be placed here only as a means of last resort. 
 *  Ideal procedure is to place all functions inside class definitions.
 */
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'functions.php');

////////////////////////////////////////////////
////////////////////////////////////////////////
/** Load all classes.
 *  All the files in the /class subfolder are automatically included.
 *  Each file declares one class or, in a few special cases, more than one.
 */
//The TElement base class must be declared first, for almost all other elements descend from it.
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR  . 'element.php');
//Read the classes directory for the remaining files
if ($dh = opendir(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes')) {
    while (($file = readdir($dh)) !== false) {
	    if(($file!='.')&&($file!='..')&&($file!='element.php')&&(strpos($file, '.php')!==false)){
        	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $file);
        	}
    	}
    closedir($dh);
	}

if ($dh = opendir(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'fancy')) {
    while (($file = readdir($dh)) !== false) {
	    if(($file!='.')&&($file!='..')&&($file!='element.php')&&(strpos($file, '.php')!==false)){
        	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'fancy' . DIRECTORY_SEPARATOR . $file);
        	}
    	}
    closedir($dh);
	}
////////////////////////////////////////////////
	
if(GJ_SHORTCUTS){
	foreach(get_declared_classes() as $classname){
		//create a function for each class
		//thus we can avoid using the keyword 'new' for object creation
		/*
		I know we shouldn't have functions with the same names as classes
		and I know that avoiding the use of a keyword is questionable
		and I know that using eval() is "wrong" (please note the quotation marks)
		but it works for me and you can disable it anytime if it bothers you:
		just define GJ_SHORTCUTS as false, or, more simply, don't use this feature.
		*/
		$c = new ReflectionClass($classname);
		if(($c->hasproperty('gjversion'))&&($c->hasMethod('__construct'))){//make sure it is a go!Johnny class
			$constructor = $c->getMethod('__construct');
			$parms = $constructor->getParameters();
			$parameters = '';
			foreach($parms as $p){
				if(trim($parameters)!=''){
					$parameters .= ', ';
					}
				$parameters .= "\$" . $p->getName();
				}
			eval("function {$classname}(){\n"
			. "	\$class = new ReflectionClass('{$classname}');\n"
			. "	\$instance = \$class->newInstanceArgs(func_get_args());\n"
			. "	return \$instance;\n"
			. "	}\n");
			}
		}
	}	
////////////////////////////////////////////////
?>
