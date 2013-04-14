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
class TA extends TElement {
	/*******************************/
	function __construct($url = '', $text = '', $title = null, $target = null, $rel = null, $ping = null, $media = null, $type = null, $hreflang = null){
		$this->init();
		if (is_array($url)){
			$params = $url;
			$url = '';
			if(isset($params['url'])){
				$url = trim($params['url']);
				}else if (isset($params['href'])){
				$url = trim($params['href']);
				}
			if ($url!=''){
				$this->p('href', $url);
				if (isset($params['text'])){
					$this->add($params['text']);
					}else{
					$this->add($url);
					}
				foreach(array('title', 'target', 'rel', 'ping', 'media', 'type', 'hreflang') as $key){
					if ((isset($params[$key]))&&($params[$key]!=null)){
						$this->p($key, $params[$key]);
						}
					}
				if(!isset($this->properties['title'])){
					$this->p('title', $text);
					}
				}
			}else{
			$url = trim($url);
			$text = trim($text);
			if($url!=''){
				if ($text==''){
					$text = $url;
					}
				$this->p('href', $url);
				$this->add($text);
				foreach(array('title', 'target', 'rel', 'ping', 'media', 'type', 'hreflang') as $key){
					if ($$key!=null){
						$this->p($key, $$key);
						}
					}
				if(!isset($this->properties['title'])){
					$this->p('title', $text);
					}
				}
			}
		}
	}