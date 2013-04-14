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
class TImg extends TElement {
	////////////////////////////////////////////////
	function __construct($src = '', $alt = '', $width = '', $height = ''){
		$this->init();
		$this->shorttag = true;
		if (is_array($src)){
			foreach(array('src', 'alt', 'width', 'height') as $key){
				if(isset($src[$key])){
					
					}
				}
			}else{
			foreach(array('src', 'alt', 'width', 'height') as $key){
				$this->p($key, $$key);
				}
			}
		}
	}

class TImgLink extends TImg {
	////////////////////////////////////////////////
	function __construct($src = '', $link = '', $alt = ''){
		parent::__construct($src, $alt);
		$this->url = $link;
		//$this->p('onclick', "window.location = '{$link}';");
		//$this->style('cursor', 'pointer');
		}
	////////////////////////////////////////////////
	function show(){
		return "<a class=\"imglink\" href=\"{$this->url}\">" . parent::show() . "</a>";
		}
	////////////////////////////////////////////////
	}
