<?php 

use Jasati\Core\Master_Controller;

/**
* master controller
*/
class Ecold_Controller extends Master_Controller
{
	private $error = array('status' => 'error', 'msg'=>'');
	public function consulta($value)
	{
		try {
			$rep = $this->model->select($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);
	}

	public function load($value)
	{
		try {
			$rep = $this->model->load($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);		
	}

	public function novo($value)
	{
		try {
			$rep = $this->model->novo($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);			
		
	}

	public function editar($value)
	{
		try {
			$rep = $this->model->update($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);		
	}
	
	public function delete($id)
	{
		try {
			$rep = $this->model->delete($id);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);			
	}

	public function upload($value)
	{
		try {
			$rep = $this->model->upload($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);		
	}

	public function functionSql($value)
	{
		try {
			$rep = $this->model->getFunctionSql($value);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
		$this->view->set('response',$rep);			
	}	
}