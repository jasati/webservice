<?php
header("Access-Control-Allow-Credentials: false");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
   header( "HTTP/1.1 200 OK" );
   exit();
}

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__));


require 'Library'.DS.'Jasati'.DS.'Core'.DS.'AutoLoad.php';
require 'Library'.DS.'Slim'.DS.'Slim.php';

\Slim\Slim::registerAutoloader();
$autoLoad = new AutoLoad();
$autoLoad->setPath(ROOT);
$autoLoad->setExt('php');

spl_autoload_register(array($autoLoad, 'loadApp'));
spl_autoload_register(array($autoLoad, 'loadModulos'));
spl_autoload_register(array($autoLoad, 'loadCore'));
spl_autoload_register(array($autoLoad, 'load'));
use Jasati\Core\Router;

define('MODULO_SYS', 'v1');


session_start();

$app = new \Slim\Slim();


/*
 * Endpoint de consutas recebe um json com dois indices
 * id_emp e consulta
 * @param json {"id_emp":"value","consulta":"sql where"}
 * @return json com os dados da consulta
 */


function requestEndPoint()
{
	$request = \Slim\Slim::getInstance()->request();
	$dados = json_decode($request->getBody(),true);
    return $dados;
}

$app->get('/', function () {
    //
    echo "<h1>***WebService Jasati V1.0***<h1>";
});


/*Ecold*/
$app->post('/'.MODULO_SYS.'/consulta', function () {;  
	$router = new Router(requestEndPoint());
});
$app->post('/'.MODULO_SYS.'/load', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/novo', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/editar', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/delete', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/upload/:id_emp,:redim,:db,:doc', function($id_emp,$redim,$db,$doc){

	$dados = array('id_emp' => $id_emp, 'redim' => $redim, 'db' => $db, 'doc' => $doc);
	$router = new Router($dados);
});

$app->post('/'.MODULO_SYS.'/deleteimg', function(){
	$dados = requestEndPoint();
	if (isset($dados['nomeImg'])) {
		$img = 'App/Upload/' . $dados['nomeImg'];
		unlink($img);
		echo json_encode(array('status' => 'ok','msg'=>'Imagem removida.' ));
	} else {
		echo json_encode(array('status' => 'error','msg'=>'Imagem não removida.' ));
	}
});

$app->post('/'.MODULO_SYS.'/functionSql', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/report', function(){
require 'Library'.DS.'MPDF'.DS.'mpdf.php';
	$dados = requestEndPoint();
	$ret = [];
	if ($dados['prm']==='C') {
		if ($dados['page']==='L') {
			$mpdf = new mPDF('utf-8', 'A4-L');
		} else {
			$mpdf = new mPDF;
		}
		$name = $dados['nomePrefix'].$dados['numero'].'.pdf';
		$html = $dados['html'];
		//$stylesheet1 = file_get_contents('App'.DS.'Templates'.DS.'Default'.DS.'css'.DS.'bootstrap.min.css');
		$stylesheet2 = file_get_contents('App'.DS.'Templates'.DS.'Default'.DS.'css'.DS.'style.css');
		//$mpdf->WriteHTML($stylesheet1,1);
		$mpdf->WriteHTML($stylesheet2,1);
		$mpdf->WriteHTML($html,2);
		$mpdf->Output('App'.DS.'Tmp'.DS.$name,'F');
		$ret = json_encode(array( 'report_name' => $name));
	} else {
		$nomePrefix = $dados['nomePrefix'];
		array_map('unlink', glob('App'.DS.'Tmp'.DS.$nomePrefix.'*.pdf'));//apagar os arquivos
		$ret = json_encode(array( 'status' => 'ok'));
	}
	echo $ret;
});

$app->post('/'.MODULO_SYS.'/ipaddr', function(){
	$ret = json_encode(array('andress' => $_SERVER["REMOTE_ADDR"]));
	echo $ret;
});

$app->post('/'.MODULO_SYS.'/pagseguro', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/getResponse', function(){
	$router = new Router(requestEndPoint());
});


$app->post('/'.MODULO_SYS.'/enviarEmail', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/'.MODULO_SYS.'/dataAtual', function(){
	$tz = 'America/Sao_Paulo';
	$timestamp = time();
	$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
	$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
	$dt->format('Y-m-d');
	$ret = json_encode(array('data' => $dt->format('Y-m-d')));
	echo $ret;
});

$app->post('/'.MODULO_SYS.'/licenca', function () {
	$router = new Router(requestEndPoint());
});

$app->run();
