<?php
require_once 'config.php';

function strtohex($string){
  $string = str_split($string);
  foreach($string as &$char)
    $char = "\x".dechex(ord($char));
  return implode('',$string);
}


foreach($files as $file){
if(!is_dir($file)&&is_file($file)){
	
$ignore = [];	
if($ignore_dest !== null){
	$ign = file_get_contents($ignore_dest);
	$ignore = explode(',',$ign);
}

if(!in_array(basename($file),$ignore)){
$filename = $file;
$pathinfo = pathinfo($filename);
$filename_ext = $pathinfo['extension'];
$filename_tmp = 'tmp/'.$pathinfo['filename'].'.txt';
$f_content = file_get_contents($filename);
$f_lines = explode("\n",$f_content);
$c_lines = count($f_lines);
$s_from = 0;
$e_in = $c_lines-1;
$compress = 1;
$write = $new_dir.'/'.basename($filename);

$content = '';
for($i=$s_from;$i<=$e_in;$i++){
	$content.= $f_lines[$i]."\n";
}
for($i=1;$i<=$compress;$i++){
$content = gzdeflate($content);
file_put_contents($filename_tmp,$content);
$content = base64_encode($content);
file_put_contents($filename_tmp,$content);
}

$start_uncompressing = file_get_contents($filename_tmp);
$new_content = '';
$new_content.= $start_uncompressing;
$content = '<?php'."\n";
$content.="/**
 * Script By Organaziation Name
 * PHP Version 5.6
 */

/**
 * Script By Organizarion Name
 * @author Sajjad Hossain (@sajjad_hira12) <sajjad.hira12@gmail.com>
 * @author https://facebook.com/sajjadhossainhira
 * @copyright 2019 Sajjad Hossain
 */\n";
$content.='function _encodeit($c){$a="\x67\x7a\x69\x6e\x66\x6c\x61\x74\x65";$b="\x62\x61\x73\x65\x36\x34\x5f\x64\x65\x63\x6f\x64\x65";$c=$a($b($c));return $c;}';
$content.= '$u= "'.$new_content.'";';
$content.= 'eval("?>"._encodeit($u));';
file_put_contents($write,$content);
@unlink($filename_tmp);
	echo basename($file).' encoded successfully.'."\n";
	
}
}
}
echo $dir.' operation has been completed';
?>