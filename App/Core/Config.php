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
            case 'base_inicial':
                $db = array(
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "base_inicial";
                break;
            case 'ecc':
                $db = array(
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "ecc";
                break;
            case 'psclse':
                $db = array(
                'tipo'=>'Mysql',
                'servidor'=>'localhost',
                'usuario'=>'root',
                'senha'=>'mySql',
                'database'=>$value);
                $this->appnome = "psclse";
                break;
            default:

                break;
        }
        return $db;
    }

    // public function getConectionDb($value=array())
    // {
    //   try {
    //     if (isset($value->db)) {
    //       $ambiente = isset($value->ambiente)?$value->ambiente:0;
    //
    //     } else {
    //       return false;
    //     }
    //   } catch (Exception $e) {
    //     return $e;
    //   }
    //
    //
    // }

    public function startSistema($sistema)
    {
      if (isset($sistema)) {
        $sistemas = array(
          array(
            'sistema'    => 'psicanalise',
            'corLayoute' => 'default',
            'versao'     => '0.0.1',
            'appTitle'   => 'WebApp Swishi',
            'appSubtitle'=> 'Aplicativo para psicanálise',
            'modPerm '   => true,
            'ambiente'   =>  array(
              array(
                'posicao'   => 'local',
                'db'        => 'psclse',
                'img'       => 'http://mucontratos.alan.dev/App/Upload/',
                'report'    => 'http://mucontratos.alan.dev/App/Tmp/',
                'urlSistema'=> 'http://localhost:3000/',
              ),
              array(
                'posicao'   => 'producao',
                'db'        => 'jasatico_swishi',
                'img'       => 'https://ws.swishi.jasati.com.br/App/Upload/',
                'report'    => 'https://ws.swishi.jasati.com.br/App/Tmp/',
                'urlSistema'=> 'https://app.swishi.jasati.com.br',
              )
            )
          )
        );
        //print_r($sistemas);
        if (isset($sistemas[$sistema])) {
          return $sistemas[$sistema];
        } else {
          return array('status' => 'error', 'msg'=>'O Sistema informado não foi configurado, adicione no aquivo de configurações da API.');
        }

      } else {
        return array('status' => 'error', 'msg'=>'Sistema não informado! informe qual o sistema está sendo iniciado');
      }
    }
}
