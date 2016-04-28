<?php 

namespace Jasati\Core;

use App\Core\Config;

/**
* Classe de rotas
*/
class Router
{
	use \Jasati\Utilities\Inflector;
	use \Jasati\Utilities\Request;

	private $config;
	private $url;
	private $mvc;
	private $params;

	public function __construct($value=null)
	{
		$this->config = new Config();
        $this->url=$this->request()['url'];
        $this->cleanUrl();
        $this->setMvc();
        $this->loadMvc($value);
	}

    private function cleanUrl($url=true, $params=false)
    {
        if ($url) {
            if (preg_match('/.{1,}(\/){1}$/', $this->url)) {
                $this->url=substr($this->url, 0, -1);
            }
        }
        if ($params) {
            $this->params=substr($this->url, 1);
        }
    }

    private function urlArray()
    {
        if (preg_match('/.{1,}(\/){1}$/', $this->url)) {
            $this->url=substr($this->url, 0, -1);
        }
    }

    private function setMvc()
    {
        if (isset($this->config->router[$this->url])) {
            $this->mvc=$this->config->router[$this->url];
        } else {
            $this->cleanUrl(false, true);
            $this->params=explode('/', $this->params);
            
            $this->params[0]=$this->upperCamelCase($this->params[0]);
            
            if ($this->url=='/') {
                $this->mvc=array(
                    'model'=>'Index',
                    'controller'=>'Index',
                    'action'=>'index',
                );
            } else {
                $this->mvc['model']=$this->params[0];
                $this->mvc['controller']=$this->params[0];
                if (isset($this->params[1])) {
                    $this->mvc['action']=$this->params[1];
                }
            }
        }

        
        if (!isset($this->mvc['action']) || empty($this->mvc['action'])) {
            $this->mvc['action']='index';
        }
        if (!isset($this->mvc['controller']) || empty($this->mvc['controller'])) {
            $this->mvc['controller']='Index';
        }
        
    }

    private function loadMvc($value)
    {
        $controller=$this->mvc['controller'].'_Controller';
        $action=$this->mvc['action'];
            
        $controller = new $controller($this->mvc);
        $controller->$action($value);
        
    }

}