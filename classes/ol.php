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
class TOl extends TElement {
	////////////////////////////////////////////////
	function getcontent(){
		$res = '';
		foreach($this->items as $item){
			$res .= "<li>{$item}</li>\n";
			}
		return $res;
		}
	
	}

class TOrderedList extends TOl {
	/*******************************/
	function init(){
		parent::init();
		$this->type = 'ol';
		}
	}
