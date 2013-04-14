<?php
class TJohnnycode {
	var $name = '';
	var $language = '';
	var $data = array();
	var $type = 'simple';
	var $text = '';
	var $separator = ' ';
	var $keepseparator = false;
	//////////////////////////////////////
	function __construct($text, $dataorfilename, $type = 'simple', $separator = ' '){
		$this->text = $text;
		$this->type = $type;
		$this->separator = $separator;
		if (is_array($dataorfilename)){
			$this->data = $data;
			}else if (is_string($dataorfilename)){
			$this->load($dataorfilename);
			}
		}
	//////////////////////////////////////
	function load($flnm){
		if (file_exists($flnm)){
			//$this->data = unserialize(file_get_contents($flnm));
			require_once($flnm);
			}
		}
	//////////////////////////////////////
	function save($flnm){
		$fh = fopen($flnm, 'w');
		fwrite($fh, '<?php' . "\n");
		foreach($this->data as $key => $val){
			fwrite($fh, "\$this->data['{$key}'] = '{$val}';\n");
			}
		fclose($fh);
		}
	//////////////////////////////////////
	function render($text = null){
		if ($text==null){
			$text = $this->text;
			}
		$fname = "render_{$this->type}";
		return $this->$fname($text);
		}
	//////////////////////////////////////
	function render_simple($text){
		$text = trim($text);
		if ($text==''){
			return '';
			}else{
			$res = '';
			for($i=0;$i<strlen($text);$i++){
				$c = substr($text, $i, 1);
				if (isset($this->data[$c])){
					$res .= $this->data[$c];
					}else{
					$res .= $c;
					}
				}
			return $res;
			}
		}
	//////////////////////////////////////
	function render_complex($text){
		$res = '';
		foreach(explode($this->separator, $text) as $e){
			if ($res!=''){
				if ($this->keepseparator){
					$res .= $this->separator;
					}
				}
			if (isset($this->data[$e])){
				$res .= $this->data[$e];
				}else{
				$res .= $e;
				}
			}
		return $res;
		}
	//////////////////////////////////////
	public function __toString(){
		return $this->render();
		}
	//////////////////////////////////////
	}
?>