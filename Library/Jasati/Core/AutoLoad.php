<?php 

/**
* Carregamento de classes atomaticamente
*/
class AutoLoad
{

	protected $ext;
	protected $prefix;
	protected $sufix;

    /**//**
     * Define o caminho local até a raiz do script
     * @param string $path caminho completo até o script
     * @return Nao tem retorno
     */
    public function setPath($path)
    {
    	set_include_path($path);
    }

    /**//**
     * Define a extenção do arquivo a ser exportado
     * @param string $ext extenção sem ponto
     * @return Nao tem retorno
     * 
     */
    public function setExt($ext)
    {
    	$this->ext = '.' .$ext;
    }

    /**//**
     * Define se havera algo a se colocar antes do nome do arquivo
     * @param string $prefix o que vai antes do nome do arquivo
     * @return nao tem retorno
     */
    public function setPrefix($prefix)
    {
    	$this->prefix = $prefix;
    }

    /**//**
     * Define se havera algo a se colocar apos o nome do arquivo
     * @param string $sufix o que vai apos o nome do arquivo
     * @return Nao tem retorno
     * 
     */
    public function setSufix($sufix)
    {
    	$this->sufix = $sufix;
    }

    /***//**
     * Transfoma a classe em um caminho até o arquivo correspondente
     * @param string $className caminho completo até o script
     * @return $fileName o caminho até o arquivo da classe
     * 
     */
    protected function setFilename($className)
    {
    	$className = ltrim($className,'\\');
    	$fileName = '';
    	$namespace = '';
    	if ($lastNsPos = strrpos($className, '\\')) {
    		$namespace = substr($className, 0, $lastNsPos);
    		$className = substr($className, $lastNsPos + 1);
    		$className = $this->prefix.$className.$this->sufix;
    		$fileName = str_replace('\\', DS, $namespace) .DS;
    	}
    	$fileName .= str_replace('_', DS, $className). $this->ext;
    	return $fileName;
    }


    /**//**
     * Carrega aquivos da Library
     * 		
     * @param string $className a classe a se carregar
     * @return nao tem retorno
     */
    public function loadCore($className)
    {
    	$fileName = $this->setFileName($className);
    	$fileName = get_include_path().DS.'Library'.DS.$fileName;

    	if (is_readable($fileName)) {
    		include $fileName;
    	}
    }
    
    /**//**
     * Carrega os aquivos da aplicação
     * @param string $className a classe a se carregar argument 
     * @return nao tem retorno
     *  
     * */
    public function loadApp($className)
    {
    	$fileName = $this->setFileName($className);
    	$fileName = get_include_path().DS.'App'.DS.$fileName;

    	if (is_readable($fileName)) {
    		include $fileName;
    	}
    }

    /*
     ** Carrega os módulos da aplicação
     *
     * @param string $className a classe a se carregar
     *
     * @return  Não retorna nada
     */
    public function loadModulos($className)
    {
        $fileName=$this->setFileName($className);
        $fileName=get_include_path().DS.'App'.DS.'Modulos'.DS.$fileName;
        
        if (is_readable($fileName)) {
            include $fileName;
        }
    }

     /**
     * Carrega outros arquivos
     *
     * @param string $className a classe a se carregar
     *
     * @return  retorna um erro caso o arquivo não seja encontrado
     *
     */
    public function load($className)
    {
        $fileName=$this->setFileName($className);
        $fileName=get_include_path().DS.$fileName;
        
        if (is_readable($fileName)) {
            include $fileName;
        } else {
            echo $fileName.' não encontrado!';
            echo '<pre>';
            var_dump(debug_backtrace());
            echo '</pre>';
            exit;
        }
    }




}	