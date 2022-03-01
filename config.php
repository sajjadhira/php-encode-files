<?php
@session_start();

$dirs = [
		'C:\xampp\htdocs\durectoryname' // which one is main directory
		];


$max_position = count($dirs);
if(!file_exists('tmp/position.txt')){
	$position = 0;
	file_put_contents('tmp/position.txt',$position);
}else{
	$position = file_get_contents('tmp/position.txt');
	$position = $position+1;
	if($position>=$max_position){
		$position = 0;
	}
	file_put_contents('tmp/position.txt',$position);	
}

$dir = $dirs[$position];
$dir_r = str_replace('\\','/',$dir);
$ex = explode('/',$dir_r);
$last = end($ex);


$find = 'durectoryname'; // raw directory name 
$repo = 'newdirectoryname'; // new dierctory name

$new_dir = str_replace($find,$repo,$dir);
// print_r($new_dir);die;
$files = null;
if(is_dir($dir)){
$find = rtrim($dir_r,'/').'/*';
$files = glob($find);
}

// creating directory if not exists
if(!is_dir('tmp')){mkdir('tmp',0755);}
if(!is_dir($new_dir)){mkdir($new_dir,0755);}



// this file from main source directory will prevent files to encode

$ignore_dest =null;
if(file_exists($dir.'/.ignore')){
	$ignore_dest = $dir.'/.ignore';
}