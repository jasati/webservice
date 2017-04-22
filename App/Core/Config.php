<?php

namespace App\Core;

class Config
{
    public $appnome;

    public function database($value='')
    {
        switch ($value) {
            case 'sorveteria':
                $db = array(        
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "eCold";
                break;
            case 'mucompras':
                $db = array(        
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "MuCompras";
                break;
            case 'locdress':
                $db = array(
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "LocDress";
                break;
            case 'smart_reserva':
                $db = array(
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "smart_reserva";
                break;
            default:
                
                break;
        }
        return $db;
    }
}