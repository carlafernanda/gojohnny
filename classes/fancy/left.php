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
class TLeft extends TDiv {
	/*******************************/
	function __construct(){
		parent::__construct(func_get_args());
		$this->setclass('left-align');
		}
	
	}