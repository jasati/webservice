<?php 

namespace Jasati\Utilities;

trait Inflector
{
    public function upperCamelCase($string=null)
    {
    	$string = strtolower($string);//converte todas para minusculas
    	$string = ucwords($string);//tranforma o primeiro caracter da string para maiuscula
    	$string = str_replace(' ', '', $string);

    	return $string;
    }

    public function slug($string=null, $separator='-')
    {
    	$string = strtolower($string);
    	$string = str_replace(' ', $separator, $string);

    	return $string;
    }
}