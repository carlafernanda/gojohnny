<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Arašatuba - SP - Brazil - 2013
*/
if(!class_exists('TInput')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.php');
	}
class TText extends TInput {
	/*******************************/
	function __construct($content = '', $placeholder = ''){
		parent::__construct($content);
		$this->type = 'input';
		$this->p('type', 'text');
		$this->p('placeholder', $placeholder);
		}
	/*******************************/
	}

class TEdit extends TText {}
