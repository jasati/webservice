<?php

use Jasati\Core\Master_Model;

/**
* Index model
*/
class V1_Model extends Master_Model
{

	/**
	 * Estrutura da array value
	 * modulo = nome da tabela
	 * id_index_main = nome do campo id da tabela principal
	 * valor_id_main = valor do id
	 * id_tabela = nome do campo id da tabela
	 * valor_id = o valor id da tabela
	 * estrutura = os campos da tabela e valores
	 * consulta = sql where
	 */
	public function load($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		$where = array('where' =>[$value['id_tabela'] . ' = ' . $value['valor_id']]);
		return $this->db->read('first',$where);
	}

	public function select($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		$where = array('where' =>$value['id_index_main'] . ' = '. $value['valor_id_main'] . $value['consulta']);

		if (isset($value['campos'])) {
			if (!empty($value['campos'])) {
				$where += array('campos' => $value['campos'] );
			}
		}

		if (isset($value['inner_join'])) {
			if (!empty($value['inner_join'])) {
				$where += array('inner_join' => $value['inner_join'] );
			}
		}

		if (isset($value['left_join'])) {
			if (!empty($value['left_join'])) {
				$where += array('left_join' => $value['left_join'] );
			}
		}

		if (isset($value['group by'])) {
			if (!empty($value['group by'])) {
				$where += array('group by' => $value['group by'] );
			}
		}

		if (isset($value['order by'])) {
			if (!empty($value['order by'])) {
				$where += array('order by' => $value['order by'] );
			}
		}
		//pegar a quantidade de registros da consulta
		$ret = array('qtde' => $this->db->read('count',$where));

		if (isset($value['limit'])) {
			if (!empty($value['limit'])){
				$where += array('limit' => $value['limit']);
			}
		}
		$ret += array('reg' => $this->db->read('all',$where));
		return $ret;
	}

	public function novo($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		if (isset($value['estrutura'][0])) {
			//print_r($value['estrutura']);
			for ($i=0; $i < count($value['estrutura']); $i++) {
				$r = array($i => $this->db->create($value['estrutura'][$i]));
			}
			return $r;
		} else {
			return $this->db->create($value['estrutura']);
		}
	}

	public function update($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		//$where = array($value['id_tabela'] =>$value['valor_id']);
		//return $this->db->update($where,$value['estrutura']);
		if (isset($value['estrutura'][0])) {
			for ($i=0; $i < count($value['estrutura']); $i++) {
				$r = $this->db->updateM($value['estrutura'][$i],$value['id_tabela']);
			}
			return $r;
		} else {
			return $this->db->updateM($value['estrutura'],$value['id_tabela']);
		}

	}

	public function delete($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		if (isset($value['estrutura'][0])) {
			for ($i=0; $i < count($value['estrutura']); $i++) {
				$r = $this->db->deleteM($value['estrutura'][$i],$value['id_tabela']);
			}
			return $r;
		} else {
			return $this->db->delete([$value['id_tabela']=>$value['valor_id']]);
		}
	}
	public function upload($value)
	{
		$nomeArq = $this->uploadImg($value['id_emp'],$value['redim']);
		if ($nomeArq['status']=='ok') {
			$this->connectDb($value['db'],'galeria');

			$estrutura = array('id_emp' =>$value['id_emp'] , 'imagem'=> $nomeArq['nomeArq'], 'doc'=>$value['doc']);

			$resp = $this->db->create($estrutura);
			return array_merge($resp,$estrutura);
		} else {
			return $nomeArq;
		}
	}

	public function getFunctionSql($value)
	{
		$this->connectDb($value['db'],$value['modulo']);
		return $this->db->functionSql($value['valor_id']);
	}
	public function log($value)
	{
		$this->logger($value);
	}
}
