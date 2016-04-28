<?php 

namespace Jasati\Core;

use App\Core\Config;
use \Jasati\Utilities\Upload;

/**
* Class Master model
*/
class Master_Model
{
	
	use \Jasati\Utilities\Inflector;

	public $mvc;
	protected $inflector,$db,$mysql,$table;



	public function __construct($returnMvc)
	{
		$this->mvc = $returnMvc;
	}
	public function connectDb($table=null)
	{
		$this->table = $table;
		if (!isset($this->table)) {
			$this->table = $this->slug($this->mvc['model'],'_');
		}
		if ($this->table) {
			$config = new Config();
			$db = $config->database;			
			$data_source='Jasati\Core\Master\Db_'.$db['tipo'];
			$this->db = new $data_source($db,$this->table);
		}
	}

	public function uploadImg($emp,$redim)
	{
		if (!empty($_FILES['file'])) {
		    $upload = new Upload($_FILES['file'], 1000, 800, "App/Upload/");
		    return $upload->salvar($emp,$redim);
		} else {
			return "Arquivo anexo não encontrado.";
		}		
	}
	public function logger($value)
	{
		$myfile = fopen("log.txt", "w") ;
		fwrite($myfile, $value); 
	}	

}