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
class TInput extends TElement {
	/*******************************/
	function __construct($content = ''){
		parent::__construct();
		$this->p('type', GJ_DEFAULTINPUTTYPE);
		$this->shorttag = true;
		$this->p('value', $content);
		}
	/*******************************/
	function show(){
		$this->setID();
		if (!isset($this->properties['name'])){
			$this->p('name', $this->p('id'));
			}
		return parent::show();
		}
	/*******************************/
	function disabled($val = true){
		$this->p('disabled', $val);
		}
	/*******************************/
	function required($val = true){
		$this->p('required', $val);
		}
	/*******************************/
	}