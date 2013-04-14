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
$.expr[':'].containsIgnoreCase = function(e,i,m){
    return jQuery(e).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	};

function ajax(anarea, aurl, img){
	//alert(aurl);
	if (img == null) {
		img = "img/wait.gif";
		}
	jQuery("#" + anarea).html('<div align="center"><img src="' + img + '"></div>');//copy this file to where it is accessible for your application
	jQuery("#" + anarea).load(aurl);
	//jQuery("#" + anarea + "_wait").attr("src", "");
	}


function urlEncodeCharacter(c){
	return '%' + c.charCodeAt(0).toString(16);
	};

function urlDecodeCharacter(str, c){
	return String.fromCharCode(parseInt(c, 16));
	};

function urlEncode(s){
	return encodeURIComponent( s ).replace( /\%20/g, '+' ).replace( /[!'()*~]/g, urlEncodeCharacter );
	};

function urlDecode(s){
	return decodeURIComponent(s.replace( /\+/g, '%20' )).replace( /\%([0-9a-f]{2})/g, urlDecodeCharacter);
	};

function val(area, newval){
	if (newval!=null){
		$(area).val(newval);
		}
	return $(area).val();
	}

function include(filename){
	//source: http://forums.digitalpoint.com/showthread.php?t=146094
	var head = document.getElementsByTagName('head')[0];
	script = document.createElement('script');
	script.src = filename;
	script.type = 'text/javascript';
	
	head.appendChild(script)
	}

function harvest(){
	//return a string passing urlEncoded values of the specified fields as parameters
	s = '';
	for (var i = 0; i < arguments.length; i++) {
		if (s!=''){
			s = s + '&';
			}
		if ($('#' + arguments[i]).is(':checkbox')){
			if($('#' + arguments[i]).attr('checked')){
				s = s + arguments[i] + '=' + $('#' + arguments[i]).val();
				}else{
				s = s + arguments[i] + '=0';
				}
			
			}else if ($('input[name=' + arguments[i] + ']').is(':radio')){
			s = s + arguments[i] + '=' + urlEncode($('input[name=' + arguments[i] + ']:checked').val());
			}else{
			s = s + arguments[i] + '=' + urlEncode($('#' + arguments[i]).val());
			}
		}	
	return s;
	}

function go(where){
	window.location = where;
	}

function submitform(formid, fields){
	$('#' + formid).submit();
	url = $('#' + formid).attr('action');
	s = '';
	if (fields==null){
		$('#' + formid).find(':input').each(function(){
			if (s!=''){
				s = s + '&';
				}
			s = s + $(this).attr('name') + '=' + urlEncode($(this).val());
			});
		}else{
		for (var i = 0; i < fields.length; i++) {
			if (s!=''){
				s = s + '&';
				}
			if ($('#' + fields[i]).is(':checkbox')){
				if($('#' + fields[i]).attr('checked')){
					s = s + fields[i] + '=' + $('#' + fields[i]).val();
					}else{
					s = s + fields[i] + '=0';
					}
				
				}else if ($('input[name=' + fields[i] + ']').is(':radio')){
				s = s + fields[i] + '=' + urlEncode($('input[name=' + fields[i] + ']:checked').val());
				}else{
				s = s + fields[i] + '=' + urlEncode($('#' + fields[i]).val());
				}
			}
		}
	if(url.indexOf('?') === -1){
		url = url + '?';
		}
	//go(url + s);
	}





