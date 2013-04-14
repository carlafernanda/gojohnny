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
class TTr extends TElement {
	/*******************************/
	function __construct(){
		parent::__construct();
		foreach(func_get_args() as $item){
			$this->add($item);
			}
		}
	/*******************************/
	function add($item){
		if(
			(isset($item->type))
			&&
			(
				(($item->type=='td'))
				||
				(($item->type=='th'))
			)
			){
			//we have one single td object
			$this->items[] = $item;
			}else if (is_array($item)){
			//we have an array of items; recursively deal with each one
			foreach($item as $subitem){
				$this->add($subitem);
				}
			}else{
			//we have something else; 
			$items = func_get_args();
			if(count($items)>0){
				if(count($items)>1){
					//if more than one item, deal with each one of them separately
					foreach($items as $subitem){
						$this->add($subitem);
						}
					}else{
					//if one single item, add it inside a td class object
					$this->items[] = TTd($item);
					}
				}
			}
		
		}
	/*******************************/
	}
