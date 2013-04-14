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
class TDBTable {
	var $name = '';
	var $fields = array();
	var $properties = array();
	function __construct($aname = '', $fields = null){
		require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'auxclasses' . DIRECTORY_SEPARATOR . 'db_table_field.php');
		$aname = trim($aname);
		if($aname!=''){
			$this->name = $aname;
			}
		if(is_array($fields)){
			foreach($fields as $field){
				if(is_array($field)){
					$newfield = new TDBTableField();
					foreach(array('name', 'type', 'length', 'collation', 'attributes', 'primary', 'null', 'default', 'autoincrement', 'comments', 'values') as $key){
						if(isset($field[$key])){
							$newfield->$key = $field[$key];
							}
						}
					if (($newfield->name!='')&&($newfield->type!='')){
						$this->fields[] = $newfield;
						}
					}else if ((is_object($field))&&(get_class($field)=='TDBTableField')){
					$this->fields[] = $field;
					}
				}
			}
		}
	}
