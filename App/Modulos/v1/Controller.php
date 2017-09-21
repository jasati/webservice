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
			if ((isset($value['url'])) and (isset($value['request']))) {
				$url = $value['url'];
				//

				//configurar curl
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $value['request']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				if (isset($value['fields'])) {
					$fields = http_build_query($value['fields']);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				}

				// curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				//executa
				$xml = curl_exec($curl);
				curl_close($curl);
				//pega o xml e transforma e json
				//print_r($xml);
				//$rep = simplexml_load_string($xml);
				$this->view->set('response',array('status'=>'ok','xml'=>$xml));
			} else {
				$ret = json_encode(array('status' => 'error', 'msg'=>'Faltando parametros!' ));
				$this->view->set('response',$ret);
			}

		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}

	}

	public function getResponse($value)
	{
		try {
			if ((isset($value['url'])) and (isset($value['request']))) {
				$url = $value['url'];
				$key = $value['key'];
				//
				$headers = [
				    'X-Auth-Token: api-key '.$key,
				    'Content-Type: application/json'
				];
				//configurar curl
				$curl = curl_init($url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $value['request']);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
				if (isset($value['body'])) {
					$fields = json_encode($value['body']);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
				}
				curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

				// curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				//executa
				$res = curl_exec($curl);
				curl_close($curl);
				//pega o xml e transforma e json
				//print_r($fields);
				//$rep = simplexml_load_string($xml);
				$this->view->set('response',array('status'=>'ok','data'=>$res));
			} else {
				$ret = json_encode(array('status' => 'error', 'msg'=>'Faltando parametros!' ));
				$this->view->set('response',$ret);
			}

		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}

	}
	public function enviarEmail($value)
	{
		try {

			$para = $value['email'];
			$assunto = $value['assunto'];
			$mensagem = $value['mensagem'];
			$headFrom = $value['head_from'];

			//5 – agora inserimos as codificações corretas e tudo mais.
			$headers = "Content-Type:text/html; charset=UTF-8\n";
			$headers .= "From: ".$headFrom."\n";
			//Vai ser //mostrado que o email partiu deste email e seguido do nome
			//$headers .= "X-Sender: <".$email.">\n";
			//email do servidor //que enviou
			$headers .= "X-Mailer: PHP/".phpversion()."\n";
			$headers .= "X-IP: ".$_SERVER['REMOTE_ADDR']."\n";
			//$headers .= "Return-Path: <".$email.">\n";
			//caso a msg //seja respondida vai para este email.
			//$headers .= "MIME-Version: 1.0\n";
			//função que faz o envio do email.
			$enviado = mail($para, $assunto, $mensagem, $headers);
			if ($enviado) {
				$this->view->set('response',array('status'=>'ok','msg'=> 'Email enviado com sucesso!'));
			} else {
				$this->view->set('response',array('status'=>'error','msg'=> 'Email não enviado.'));
			}
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}
	}

	public function licenca($value)
	{
		try {
			$myfile = fopen("log.txt", "w") ;
			$str = json_encode($value);
			if (isset($_POST['hottok'])){
				fwrite($myfile, $_POST['hottok']);
			} else {
				fwrite($myfile, $str);
			}
			$this->view->set('response',array('status'=>'ok','msg'=> 'Dados recebido com sucesso.'));
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}

	}

	public function startSistema($value)
	{
		try {
			$rep = $this->model->startSistema($value);
			$this->view->set('response',$rep);
		} catch (Exception $e) {
			$this->error['msg'] = $e->getMessage();
			$this->view->set('response',$this->error);
		}

	}
}
