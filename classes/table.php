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
//some classes used only by this class
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'table_part.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'table_head.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'table_body.php');
require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'table_foot.php');
////////////////////////////////////////////////////////////////////////////////////////
class TTable extends TElement {
	/*******************************/
	function __construct($something){
		parent::__construct();
		$this->caption = '';
		$this->thead = new TTHead();
		$this->tbody = new TTBody();
		$this->tfoot = new TTFoot();
		$this->head = &$this->thead;
		$this->body = &$this->tbody;
		$this->foot = &$this->tfoot;
		$this->items = &$this->tbody->items;
		if((is_object($something)&&(isset($something->type))&&($something->type=='tr'))){
			//something is a TTr class object, add it directly
			$this->tbody->items[] = $something;
			}else{
			if (is_array($something)){
				if(count($something)>0){
					foreach($something as $row){
						if((is_array($row))||((is_object($row))&&(isset($row->type))&&($row->type=='tr'))){
							$this->addrow($row);
							}else{
							$this->addrow($something);
							}
						}
					}
				}else{
				$something = func_get_args();
				if(count($something)>0){
					if(is_array($something[0])){
						foreach($something as $row){
							$this->addrow($row);
							}
						}else{
						$this->addrow($something);
						}
					}
				}
			}
		}
	/*******************************/
	function add($something){
		if((is_object($something)&&(isset($something->type))&&($something->type=='tr'))){
			//something is a TTr class object, add it directly
			$this->tbody->items[] = $something;
			}else{
			if (is_array($something)){
				if(count($something)>0){
					foreach($something as $row){
						if((is_array($row))||((is_object($row))&&(isset($row->type))&&($row->type=='tr'))){
							$this->addrow($row);
							}else{
							$this->addrow($something);
							}
						}
					}
				}else{
				$something = func_get_args();
				if(count($something)>0){
					if(is_array($something[0])){
						foreach($something as $row){
							$this->addrow($row);
							}
						}else{
						$this->addrow($something);
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
		$this->tbody->items[] = $rowitems;
		}
	/*******************************/
	function getcaption(){
		if($this->caption!=''){
			return "<caption>{$this->caption}</caption>";
			}else{
			return '';
			}
		}
	/*******************************/
	function getcontent(){
		return $this->getcaption() . $this->head . $this->foot . $this->body;
		}
	/*******************************/
	function parse($text, $coldelimiter = '|', $rowdelimiter = "\n"){
		$text = trim($text);
		if($text!=''){
			foreach(explode($rowdelimiter, trim($text)) as $row){
				$this->addrow(explode($coldelimiter, trim($row)));
				}
			}
		}
	/*******************************/
	function addheader($items = array()){
		if(!is_array($items)){
			$items = func_get_args();
			}
		$row = TTr();
		foreach($items as $item){
			$row->add(TTh($item));
			}
		$this->addrow($row);
		}
	/*******************************/
	/*******************************/
	}