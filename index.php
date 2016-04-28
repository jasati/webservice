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

define('MODULO_SYS', 'ecold');


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
    //inicio
    $router = new Router("***eCold - Sistema para Controle de Sorveterias***");
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

$app->post('/'.MODULO_SYS.'/upload/:id_emp,:redim', function($id_emp,$redim){
	$arr = array('id_emp' => $id_emp, 'redim' => $redim );
	$router = new Router($arr);
});

$app->post('/'.MODULO_SYS.'/deleteimg', function(){
	$dados = requestEndPoint();
	if (isset($dados['nomeImg'])) {
		$img = 'App/Upload/' . $dados['nomeImg'];
		unlink($img);
		echo json_encode(array('status' => 'Sucess! imagem removida.' ));
	} else {
		echo json_encode(array('status' => 'Error! imagem não removida.' ));
	}
	
});

$app->post('/'.MODULO_SYS.'/functionSql', function(){
	$router = new Router(requestEndPoint());
});

/*empresa*/
$app->post('/empresa', function () {
	$router = new Router(requestEndPoint());
});
$app->post('/empresa/load', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/empresa/novo', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/empresa/editar', function () {
	$router = new Router(requestEndPoint());
});
$app->delete('/empresa/delete/:id', function($id){
	$router = new Router($id);
});


/*itens*/
$app->post('/item', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/item/novo', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/item/editar', function () {
	$router = new Router(requestEndPoint());
});

$app->delete('/item/delete/:id', function($id){
	$router = new Router($id);
});

/*Movimento de Estoque*/
$app->post('/movimento/entradas', function(){
    $router = new Router(requestEndPoint());
});

$app->post('/movimento/saidas', function(){
	$router = new Router(requestEndPoint());
});

$app->post('/movimento/novo', function () {
	$router = new Router(requestEndPoint());
});

/*Itens do Movimento*/

$app->post('/movimentoitens', function(){
    $router = new Router(requestEndPoint());
});

$app->post('/movimentoitens/novo', function () {
	$router = new Router(requestEndPoint());
});

$app->post('/movimentoitens/editar', function () {
	$router = new Router(requestEndPoint());
});

$app->delete('/movimentoitens/delete/:id', function($id){
	$router = new Router($id);
});

$app->run();
