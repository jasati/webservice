<?php 

namespace Jasati\Core\Master\Db;

/**
* Suporte ao PDO
*/
class Suporte_Pdo
{
	

    protected function getCampos(Array $campos, $operator='=')
    {
        $save['sql']='';
        $i = 0;
        $separador = '';
        foreach ($campos as $key => $value) {
            /*se i for > 0, colocar o separador de campos*/
            if ($i>0) {$separador = ',';}
            $save['sql'].=$separador.'`'.$key.'` '.$operator.' :'.$key.' ';
            $save['save'][':'.$key]=$value;            
            /*incrementar $i*/
            $i++;
        }
        return $save;
    }
    
    protected function pdo($sql, $values)
    {
        $this->pdoPrepare($sql);
        $this->pdoBindValue($values);
        return $this->pdoExecute($values);
    }
    
    protected function pdoPrepare($sql)
    {
        $this->mysql_exec=$this->mysql->prepare($sql);
    }
    
    protected function pdoBindValue($values)
    {
        foreach ($values as $k=>$v) {
            $this->mysql_exec->bindValue(':'.$k, $v);
        }
    }
    
    protected function pdoExecute(Array $values=array())
    {
        $exec =  $this->mysql_exec->execute($values);
        $id = $this->mysql->lastInsertId();
        $ret = array( 'status' => 'ok',
                      'row_exec' => $exec , 
                      'last_insert' => $id );
        return $ret;
    }	
}