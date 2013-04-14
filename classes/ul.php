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
class TUl extends TElement {
	////////////////////////////////////////////////
	function getcontent(){
		$res = '';
		foreach($this->items as $item){
			$res .= "<li>{$item}</li>\n";
			}
		return $res;
		}
	
	}

class TList extends TUL {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'ul';
		}
	/*******************************/
	}