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
class TForm extends TElement {
	/*******************************/
	function __construct($content = '', $action = null){
		parent::__construct($content);
		if (trim($action)=='') {
			$action = currenturl();
			}
		$this->p('action', $action);
		$this->p('accept-charset', GJ_CHARSET);
		$this->p('method', GJ_DEFAULTFORMMETHOD);
		$this->p('autocomplete', GJ_DEFAULTFORMAUTOCOMPLETE);
		$this->p('enctype', GJ_DEFAULTFORMENCTYPE);
		$this->p('novalidate', false);
		}
	/*******************************/
	function submitlink($caption = 'OK', $fields = array()){
		$res = '';
		if(trim($caption)==''){
			$caption = 'OK';
			}
		if(!is_array($fields)){
			$fields = array(trim($fields));
			}
		$this->setID();
		if (count($fields)>0){
			$fields = "'" . implode("', '", $fields) . "'";
			$res = TJSA("submitform('{$this->properties['id']}', [{$fields}]);", $caption);
			}else{
			$res = TJSA("submitform('{$this->properties['id']}');", $caption);
			}
		return $res;
		}
	/*******************************/
	function addsubmitlink($caption = 'OK', $fields = array()){
		if(!is_array($fields)){
			$fields = array(trim($fields));
			}
		$this->add($this->submitlink($caption, $fields));
		}
	/*******************************/
	}