<?php 

namespace Jasati\Core\Master;

use PDO;
use Jasati\Core\Master\Db\Suporte_Pdo;

/**
* Mysql
*/
class Db_Mysql extends Suporte_Pdo
{
	
	public $db,$table,$mysql;
	protected $mysql_exec;

	public function __construct(Array $db, $table)
	{
		$this->db=$db;
		$this->table=$table;

		if ((isset($this->db['servidor'])) and (isset($this->db['usuario'])) and (isset($this->db['senha']))) {
			$this->mysql = new PDO(
				'mysql:host='.$this->db['servidor'].';dbname='.$this->db['database'], $this->db['usuario'], $this->db['senha']
			);
			$this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			/*
			 *resolvendo problema de acentuação no banco
			 */
			$this->mysql->query("SET NAMES 'utf8'");
			$this->mysql->query('SET character_set_connection=utf8');
			$this->mysql->query('SET character_set_client=utf8');
			$this->mysql->query('SET character_set_results=utf8');
		}
	}


	public function create(Array $campos)
	{
		$save=$this->getCampos($campos);

		$fields = implode('`,`',array_keys($campos));
		$values = implode(',',array_keys($save['save']));

		$sql = 'INSERT INTO `'.$this->table.'` (`'.$fields.'`)VALUES('.$values.');';
		return $this->pdo($sql, $save['save']);
	}

	public function read($tipo='all', Array $configs=array())
	{
		$save['sql']='';
		$save['save']=array();

		if (!isset($configs['campos'])) {
			$campos='*';
		} else {
			$campos= $configs['campos'];
		}

		if (isset($configs['inner_join'])) {
			for ($i=0; $i < count($configs['inner_join']); $i++) { 
				$save['sql'] .= ' INNER JOIN '.$configs['inner_join'][$i];
			}
		}

		if (isset($configs['left_join'])) {
			for ($i=0; $i < count($configs['left_join']); $i++) { 
				$save['sql'] .= ' LEFT JOIN '.$configs['left_join'][$i];
			}
		}

		if (isset($configs['where'])) {
   			$save['sql'] .= ' WHERE '.$configs['where'];
		}

		if (isset($configs['group by'])) {
			$save['sql'].= ' GROUP BY '.$configs['group by'];
		}

		if (isset($configs['order by'])) {
			$save['sql'] .= ' ORDER BY '.$configs['order by'];
		}

		if (isset($configs['limit'])) {
			$save['sql'] .= ' LIMIT '.$configs['limit'];
		}

		if (isset($configs['offset'])) {
			$save['sql'] .= ' OFFSET '.$configs['offset'];
		}	

        $sql = 'SELECT '.$campos.' FROM '.$this->table.$save['sql'].';';
        //print_r($sql);
        $this->pdo($sql, $save['save']);

		if ($tipo=='first') {
			return $this->mysql_exec->fetch(PDO::FETCH_ASSOC);
		} elseif ($tipo=='all') {
			return $this->mysql_exec->fetchAll(PDO::FETCH_ASSOC);
		} elseif ($tipo=='count') {
			return $this->mysql_exec->rowCount();
		}
	}

	public function update(Array $conditions, Array $campos)
	{
		$save = $this->getCampos($campos);
		$conditions = $this->getCampos($conditions);
		
		$save['save']=array_merge($save['save'], $conditions['save']);
		//print_r($save['save']);

		$sql = 'UPDATE '.$this->table.' SET '.$save['sql'].' WHERE '.$conditions['sql'].';';
		//print_r($sql);
		return $this->pdo($sql, $save['save']);

	}

	public function updateM(Array $campos, $primarykey)
	{
		$save = $this->getCampos($campos);
		$conditions = array($primarykey => $campos[$primarykey]);
		//print_r($conditions);
		$conditions = $this->getCampos($conditions);

		$save['save']=array_merge($save['save'], $conditions['save']);
		//print_r($save['save']);

		$sql = 'UPDATE '.$this->table.' SET '.$save['sql'].' WHERE '.$conditions['sql'].';';
		//print_r($sql);
		return $this->pdo($sql, $save['save']);
	}

	public function delete(Array $conditions)
	{
		$save = $this->getCampos($conditions);

		$sql = 'DELETE FROM '.$this->table.' WHERE '.$save['sql'].';';
		//print_r($sql);
		return $this->pdo($sql, $save['save']);
	}

	public function deleteM(Array $campos, $primarykey)
	{
		$conditions = array($primarykey => $campos[$primarykey]);
		$save = $this->getCampos($conditions);

		$sql = 'DELETE FROM '.$this->table.' WHERE '.$save['sql'].';';
		//print_r($sql);
		return $this->pdo($sql, $save['save']);
	}

	public function functionSql($input)
	{
		$sql = 'SELECT '.$this->table.'('.$input.') as result;';
		$this->pdo($sql,['prm'=>$input]);
		return $this->mysql_exec->fetch(PDO::FETCH_ASSOC);		
	}
}