<?php 

use Jasati\Core\Master_Controller;

/**
* master controller
*/
class V1_Controller extends Master_Controller
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
		if ($value['json']=='text') {
			$this->view->set('jsonText',true);
		}
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
			$this->error['msg'] = $e->getMessage().' Arquivo : '.$e->getFile().' Linha '.$e->getLine();
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

	public function pagseguro($value)
	{
		try {
			if ((isset($value['url'])) and (isset($value['fields'])) and (isset($value['request']))) {
				$url = $value['url'];
				//
				$fields = http_build_query($value['fields']);
				//configurar curl
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $value['request']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				//executa 
				$xml = curl_exec($curl);
				curl_close($curl);
				//pega o xml e transforma e json
				$rep = simplexml_load_string($xml);
				$this->view->set('response',$rep);
			} else {
				$ret = json_encode(array('status' => 'error', 'msg'=>'Faltando parametros!' ));
				$this->view->set('response',$rep);
			}

		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}

	}


}