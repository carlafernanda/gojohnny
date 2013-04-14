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

class TTablePart extends TElement {
	/*******************************/
	function __construct(){
		parent::__construct();
		/*valid content:
		-one or more items (either strings or go!Johnny objects
		-an array of items, representing a single table row
		-an bidimensional array representing several table rows
		*/
		$this->add(func_get_args());
		}
	/*******************************/
	function add($something){
		if((is_object($something)&&(isset($something->type))&&($something->type=='tr'))){
			//something is a TTr class object, add it directly
			$this->items[] = $something;
			}else{
			//something is an array of elements, interpret as one or more rows and add
			$something = $this->returnLast2Levels(func_get_args());
			//$something = func_get_args();
			if((count($something)==1)&&((count($something[0])==1))){
				//only one row with one item
				if((is_object($something[0][0])&&(isset($something[0][0]->type))&&((($something[0][0]->type=='td'))||(($something[0][0]->type=='th'))))){
					//we have a table cell
					$this->addrow(array($something[0][0]));
					}else{
					//we have a string
					//$this->parsestring($something[0][0]);
					$this->addrow($something[0][0]);
					}
				}else{
				//we have more than one cell
				foreach($something as $row){
					if(count($row)>0){
						//we have at least one element
						$this->addrow($row);
						}
					}
				}
			}
		}
	/*******************************/
	function addrow($rowitems = array()){
		if((is_object($rowitems)&&(isset($rowitems->type))&&($rowitems->type=='tr'))){
			//no action required
			}else if (is_array($rowitems)){
			//we have an array
			$rowitems = new TTR($rowitems);
			}else{
			//we have one item or several items
			$rowitems = new TTR(func_get_args());
			}
		$this->items[] = $rowitems;
		}
	/*******************************/
	function show(){
		if(count($this->items)>0){
			return parent::show();
			}else{
			return '';
			}
		}
	/*******************************/
	}
?>