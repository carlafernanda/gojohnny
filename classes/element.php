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

class TElement {
	var $items = array();
	var $properties = array(
		'id' => null, 
		'style' => array()
		);
	var $uid;
	var $type = 'element';
	var $named = false;
	var $shorttag = false;
	var $gjversion = '7.0';
	/*******************************/
	function init(){
		$this->type = strtolower(substr(get_called_class(), 1));
		$this->uid = md5(uniqid(rand(), TRUE));//assign a unique random id
		$this->setclass();//assign a provisional class from its php class name
		}
	/*******************************/
	function __construct(){
		$this->init();
		if (func_num_args()>0){
			//add to items anything passed on creation
			foreach(func_get_args() as $arg){
				$this->add($arg);
				}
			}
		}
	/*******************************/
	function setclass($cname = null){
		$ok = GJ_AUTOCLASS;
		$cname==trim($cname);
		if($cname==''){
			//no class name specified
			if($ok){
				//use PHP class name as a default
				$cname = get_class($this);
				}
			}
		if ($cname!=''){
			$this->p('class', $cname);
			}
		}
	/*******************************/
	function add($content = ''){
		if(!is_array($content)){
			$content = func_get_args();
			}
		foreach($content as $item){
			$this->items[] = $item;
			}
		}
	/*******************************/
	function p($aproperty = null, $avalue = null, $extra = null /*used for style properties*/){
		/*
		This function always returns the value of the property indicated in the first parameter, 
		so it can be used both for setting and for getting a property.
		*/
		
		if($aproperty!=null){
			//we have something
			$aproperty = trim($aproperty);
			if(trim($aproperty)=='style'){
				//style is an array
				if ($avalue!==null){
					//we have some value
					if(is_array($avalue)){
						//we are passing one or more style rules
						foreach($avalue as $k => $v){
							$this->properties['style'][$k] = trim($v);
							}
						}else{
						$avalue = trim(strtolower($avalue));
						//$avalue here represents the css property to which a value will be assigned
						//$extra here contains the value to be assigned to a property
						if($extra==null){
							//clear a property
							if(isset($this->properties['style'][$avalue])){
								unset($this->properties['style'][$avalue]);
								}
							return '';
							}else{
							//set the value
							$this->properties['style'][$avalue] = $extra;
							}
						}
					}else{
					return '';
					}
				}else{
				//an ordinary property
				if ($avalue!==null){
					//we have a value
					$this->properties[$aproperty] = $avalue;
					if($aproperty=='id'){
						//we are setting the id of this object
						$this->named = true;
						}
					}
				if(isset($this->properties[$aproperty])){
					return trim($this->properties[$aproperty]);
					}else{
					return '';
					}
				}
			}else{
			return '';
			}
		}
	/*******************************/
	function style($key = null, $val = null){
		//a shortcut to $this->p('style'...
		return $this->p('style', $key, $val);
		}
	/*******************************/
	function setID2($id=null){
		if(!isset($this->properties['id'])){
			$this->named = false;
			}
		
		if($id==null){
			//no new id was specified
			if($this->named){
				//get already existing name
				$id = $this->p('id');
				}else{
				//get php variable name
				if(GJ_AUTOID){
					//you can turn id auto-assignment off 
					$id = $this->getvarname();
					}
				}
			}else{
			//a new id was given, keep it
			}
		$this->named = true;//we manually set the id
		return $this->p('id', $id);//set the id and return it
		
		}
	/*******************************/
	function setID($id=null){
		if(!isset($this->properties['id'])){
			$this->named = false;
			}
		
		if($id==null){
			//no new id was specified
			if($this->named){
				//get already existing name
				if(isset($this->properties['id'])){
					return $this->properties['id'];
					}else{
					return '';
					}
				}else{
				//no new id, no existing id
				if(GJ_AUTOID==true){
					//get php variable name
					//you can turn id auto-assignment off 
					$id = $this->getvarname();//this is guaranteed to return an id
					$this->named = true;
					return $this->p('id', $id);//set the id and return it
					}else{
					//no new id, no existing id, no auto id
					$this->named = true;//it was meddled with, although unset
					if(isset($this->properties['id'])){
						unset($this->properties['id']);
						}
					return '';
					}
				}
			}else{
			//a new id was given, use it
			$this->named = true;
			return $this->p('id', $id);//set the id and return it
			}
		}
	/*******************************/
	function getvarname(){
		$res = '';
		foreach($GLOBALS as $k => $v){
			if(
				   (is_object($v))
				&&(isset($v->uid))
				&&($v->uid==$this->uid)
				){
				$res = $k;
				}
			}
		//it was not possible to get the php variable name,
		//generate an id based on class name and unique id.
		if(trim($res)==''){
			$res = $this->p('class');
			if ($res==''){
				$res = get_class($this);
				}
			$res .= "_{$this->uid}";
			}
		return $res;
		}
	/*******************************/
	function getprefix(){
		$res = '<' . $this->type . $this->getproperties();
		if($this->shorttag!=true){
			$res .= ">\n";
			}
		return $res;
		}
	/*******************************/
	function getcontent(){
		$res = '';
		if(!$this->shorttag){
			foreach ($this->items as $item){
				if (is_array($item)){
					foreach ($item as $subitem){
						$res .= $subitem . "\n";
						}
					}else{
					if($item!=null){
						$res .= $item . "\n";
						}
					}
				}
			}
		return $res;
		}
	/*******************************/
	function getsuffix(){
		if($this->shorttag){
			return '>';
			}else{
			return "</{$this->type}>\n";
			}
		}
	/*******************************/
	function prefix(){//just a shortcut
		return $this->getprefix();
		}
	/*******************************/
	function content(){//just a shortcut
		return $this->getcontent();
		}
	/*******************************/
	function suffix(){//just a shortcut
		return $this->getsuffix();
		}
	/*******************************/
	function show(){
		$this->setID();
		return $this->getprefix() . 
		$this->getcontent() . 
		$this->getsuffix();
		}
	/*******************************/
	function render(){
		return $this->show();
		}
	/*******************************/
	public function __toString(){
		return $this->show();
		}
	/*******************************/
	function returnLast2Levels($item){
		if(is_array($item) && is_array(reset($item)) && is_array(reset(reset($item)))){
			//This $item has more than 2 levels, delve deeper
			return $this->returnLast2Levels(reset($item));
			}elseif(is_array($item) && is_array(reset($item)) && !is_array(reset(reset($item)))){
			//This $item has 2 levels deep of array
			return $item;
			}
		}
	/*******************************/
	function processstyle(){
		//turn $this->properties['style'] from array to string
		$style = '';
		if (isset($this->properties['style'])){
			if (is_array($this->properties['style'])){
				foreach($this->properties['style'] as $key => $value){
					$style .= "{$key}:{$value};";
					}
				}else if (is_string($this->properties['style'])){
				$style = trim($this->properties['style']);
				}
			}
		if ($style!=''){
			$this->properties['style'] =  $style;
			}else{
			unset($this->properties['style']);
			}
		}
	/*******************************/
	function getproperties(){
		$res = '';
		$this->processstyle();//turn $this->properties['style'] from array to string
		foreach($this->properties as $key => $value){
			if(is_array($value)){
				$value = implode(',', $value);
				}
			if($value!=''){
				if($value===true){
					$res .= " {$key}";
					}else{
					$value = trim($value);
					if($value!=''){
						$res .= " {$key}=\"{$value}\"";
						}
					}
				}
			}
		return $res;
		}
	/*******************************/
	static function n(){
		//n() is short for new(), which is not allowed in php
		$class = new ReflectionClass(get_called_class());
		$instance = $class->newInstanceArgs(func_get_args());
		return $instance;
		}
	/*******************************/
	static function construct(){
		$class = new ReflectionClass(get_called_class());
		$instance = $class->newInstanceArgs(func_get_args());
		return $instance;
		}
	/*******************************/
	}
?>