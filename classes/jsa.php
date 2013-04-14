<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Araçatuba - SP - Brazil - 2013
*/
if(!class_exists('TA')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'a.php');
	}

class TJSA extends TA{
	function __construct($script = '', $text = '', $title = null, $target = null, $rel = null, $ping = null, $media = null, $type = null, $hreflang = null){
		parent::__construct('javascript:void(0);', $text, $title, $target, $rel, $ping, $media, $type, $hreflang);
		$this->type = 'a';
		$this->p('onclick', $script);
		}
	}