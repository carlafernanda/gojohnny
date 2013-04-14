<?php
/*
Panglossa go!Johnny PHP library
version 7.0
release 2013-03-20
Please see the readme.txt file that goes with this source.
Licensed under the GPL, please see:
http://www.gnu.org/licenses/gpl-3.0-standalone.html
panglossa@yahoo.com.br
Arašatuba - SP - Brazil - 2013
*/
if(!class_exists('TInput')){
	require_once(GJ_PATH_LOCAL . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'input.php');
	}
class TColor extends TInput {
	/*******************************/
	function __construct($content = '#000000'){
		parent::__construct($content);
		$this->type = 'input';
		$this->p('type', 'color');
		}
	/*******************************/
	function show(){
		$colour = trim(strtolower($this->p('value')));
		foreach(array(
'black' => '#000000', 
'white' => '#ffffff', 
'red' => '#ff0000', 
'lime' => '#00ff00', 
'blue' => '#0000ff', 
'yellow' => '#ffff00', 
'cyan' => '#00ffff', 
'aqua' => '#00ffff', 
'magenta' => '#ff00ff', 
'fuchsia' => '#ff00ff', 
'silver' => '#c0c0c0', 
'gray' => '#808080', 
'maroon' => '#800000', 
'olive' => '#808000', 
'green' => '#008000', 
'purple' => '#800080', 
'teal' => '#008080', 
'navy' => '#000080', 
'maroon' => '#800000', 
'dark red' => '#8b0000', 
'brown' => '#a52a2a', 
'firebrick' => '#b22222', 
'crimson' => '#dc143c', 
'red' => '#ff0000', 
'tomato' => '#ff6347', 
'coral' => '#ff7f50', 
'indian red' => '#cd5c5c', 
'light coral' => '#f08080', 
'dark salmon' => '#e9967a', 
'salmon' => '#fa8072', 
'light salmon' => '#ffa07a', 
'orange red' => '#ff4500', 
'dark orange' => '#ff8c00', 
'orange' => '#ffa500', 
'gold' => '#ffd700', 
'dark golden rod' => '#b8860b', 
'golden rod' => '#daa520', 
'pale golden rod' => '#eee8aa', 
'dark khaki' => '#bdb76b', 
'khaki' => '#f0e68c', 
'olive' => '#808000', 
'yellow' => '#ffff00', 
'yellow green' => '#9acd32', 
'dark olive green' => '#556b2f', 
'olive drab' => '#6b8e23', 
'lawn green' => '#7cfc00', 
'chart reuse' => '#7fff00', 
'green yellow' => '#adff2f', 
'dark green' => '#006400', 
'green' => '#008000', 
'forest green' => '#228b22', 
'lime' => '#00ff00', 
'lime green' => '#32cd32', 
'light green' => '#90ee90', 
'pale green' => '#98fb98', 
'dark sea green' => '#8fbc8f', 
'medium spring green' => '#00fa9a', 
'spring green' => '#00ff7f', 
'sea green' => '#2e8b57', 
'medium aqua marine' => '#66cdaa', 
'medium sea green' => '#3cb371', 
'light sea green' => '#20b2aa', 
'dark slate gray' => '#2f4f4f', 
'teal' => '#008080', 
'dark cyan' => '#008b8b', 
'aqua' => '#00ffff', 
'cyan' => '#00ffff', 
'light cyan' => '#e0ffff', 
'dark turquoise' => '#00ced1', 
'turquoise' => '#40e0d0', 
'medium turquoise' => '#48d1cc', 
'pale turquoise' => '#afeeee', 
'aqua marine' => '#7fffd4', 
'powder blue' => '#b0e0e6', 
'cadet blue' => '#5f9ea0', 
'steel blue' => '#4682b4', 
'corn flower blue' => '#6495ed', 
'deep sky blue' => '#00bfff', 
'dodger blue' => '#1e90ff', 
'light blue' => '#add8e6', 
'sky blue' => '#87ceeb', 
'light sky blue' => '#87cefa', 
'midnight blue' => '#191970', 
'navy' => '#000080', 
'dark blue' => '#00008b', 
'medium blue' => '#0000cd', 
'blue' => '#0000ff', 
'royal blue' => '#4169e1', 
'blue violet' => '#8a2be2', 
'indigo' => '#4b0082', 
'dark slate blue' => '#483d8b', 
'slate blue' => '#6a5acd', 
'medium slate blue' => '#7b68ee', 
'medium purple' => '#9370db', 
'dark magenta' => '#8b008b', 
'dark violet' => '#9400d3', 
'dark orchid' => '#9932cc', 
'medium orchid' => '#ba55d3', 
'purple' => '#800080', 
'thistle' => '#d8bfd8', 
'plum' => '#dda0dd', 
'violet' => '#ee82ee', 
'orchid' => '#da70d6', 
'medium violet red' => '#c71585', 
'pale violet red' => '#db7093', 
'deep pink' => '#ff1493', 
'hot pink' => '#ff69b4', 
'light pink' => '#ffb6c1', 
'pink' => '#ffc0cb', 
'antique white' => '#faebd7', 
'beige' => '#f5f5dc', 
'bisque' => '#ffe4c4', 
'blanched almond' => '#ffebcd', 
'wheat' => '#f5deb3', 
'corn silk' => '#fff8dc', 
'lemon chiffon' => '#fffacd', 
'light golden rod yellow' => '#fafad2', 
'light yellow' => '#ffffe0', 
'saddle brown' => '#8b4513', 
'sienna' => '#a0522d', 
'chocolate' => '#d2691e', 
'peru' => '#cd853f', 
'sandy brown' => '#f4a460', 
'burly wood' => '#deb887', 
'tan' => '#d2b48c', 
'rosy brown' => '#bc8f8f', 
'moccasin' => '#ffe4b5', 
'navajo white' => '#ffdead', 
'peach puff' => '#ffdab9', 
'misty rose' => '#ffe4e1', 
'lavender blush' => '#fff0f5', 
'linen' => '#faf0e6', 
'old lace' => '#fdf5e6', 
'papaya whip' => '#ffefd5', 
'sea shell' => '#fff5ee', 
'mint cream' => '#f5fffa', 
'slate gray' => '#708090', 
'light slate gray' => '#778899', 
'light steel blue' => '#b0c4de', 
'lavender' => '#e6e6fa', 
'floral white' => '#fffaf0', 
'alice blue' => '#f0f8ff', 
'ghost white' => '#f8f8ff', 
'honeydew' => '#f0fff0', 
'ivory' => '#fffff0', 
'azure' => '#f0ffff', 
'snow' => '#fffafa', 
'black' => '#000000', 
'dim gray' => '#696969', 
'dim grey' => '#696969', 
'gray' => '#808080', 
'grey' => '#808080', 
'dark gray' => '#a9a9a9', 
'dark grey' => '#a9a9a9', 
'silver' => '#c0c0c0', 
'light gray' => '#d3d3d3', 
'light grey' => '#d3d3d3', 
'gainsboro' => '#dcdcdc', 
'white smoke' => '#f5f5f5', 
'white' => '#ffffff'
			) as $name => $value){
			if ($colour == $name){
				$colour = $value;
				}
			}
		$this->p('value', $colour);
		return parent::show();
		}
	/*******************************/
	}


