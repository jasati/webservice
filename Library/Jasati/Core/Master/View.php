<?php 

namespace Jasati\Core;

use App\Core\Config;

/**
* Master View
*/
class Master_View
{
	public $mvc; //Vai receber o nosso MVC
	public $data = array(); //Vai guardar os dados vindos do controller
	public $base_url; // A URL base (URL do navegador, nada haver com caminho do servidor)
	public $tema;//o tema a se usar (dentro de App/Templates)
	private $app;
	public $titulo;

	public function __construct($returnMvc)
	{
		// Faz a configuração básica da camada de view incluindo os valores 
		// das variáveis e instanciando a classe Config
		$this->mvc=$returnMvc;
		$this->base_url=$_SERVER['REQUEST_URI'];

		$config = new Config();
		$this->tema = ((isset($config->tema)) and (!empty($config->tema)))?$config->tema:'Default';
		$this->app = $config->appnome;
	}

	public function set($var, $value)
	{
		// Faz a intermediação dos dados do controller na view
		$this->data[$var]=$value;
	}


	public function conteudo()
	{

		//transforma a key do array data em variavel 
		extract($this->data);
		include ROOT.DS.'App'.DS.'Modulos'.DS.$this->mvc['controller'].DS.'View.php';
	}

	public function templateUrl($string=null)
	{
		//Retorna URL (do navegador) base do tema
		return '../App/Templates/'.$this->tema.'/'.$string;
	}

	public function __destruct()
	{ 
		//Carrega e imprime o template final no navegador
		//include ROOT.DS.'App'.DS.'Templates'.DS.'Default'.DS.'index.php';
		echo $this->conteudo();
		exit;
	}
}