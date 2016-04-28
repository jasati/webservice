<?php 

namespace Jasati\Core;

/**
* Master controller
*/
class Master_Controller
{
	
	use \Jasati\Utilities\Request;

	public $request;
	public $mvc;
	public $model;
	public $view;


	public function __construct($returnMvc)
	{

		$this->mvc=$returnMvc;
		$this->run();
	}

	public function run()
	{
		$categoria = array();
		$this->activeModel();
		$this->activeView();
		
	}
	public function activeView()
	{
		$this->view=new Master_View($this->mvc);
	}

	public function activeModel()
	{
		$modelName=$this->mvc['model'].'_Model';
		$this->model=new $modelName($this->mvc);
	}

	/***//**
	 * voltarUrl - volar para url anterior
	 * @param interger quantidade que vai voltar
	 * @return url
	 */
	protected function voltarUrl($qt)
	{
		$params = explode('/', $this->request()['base_url']);
		$count = count($params);
		$count = $count - $qt;
		$path = '/';
		for ($i=0; $i < $count; $i++) { 
			if (!empty($params[$i])) {
				$path .= $params[$i].'/';
			}
		}
		return $path;
	}

}