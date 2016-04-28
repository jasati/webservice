<?php
//$data = array("id_motoboy" => "", "nome" => "xande","cel1" => "9955-6655"); 
//$data_string = json_encode($data);                                                                                   
//$data_string = '{"id_emp":"6","fantasia":"teste 5","razao":"Empresa alterada ","status":"1"}';
//$data_string = '{"id_item":"2","id_emp":"1","tipo":"1","qt_bolas":"2","descricao":"Banana Split","detalhes":"Duas bolas de sorvete e uma banana","imagem":"imagem.jpg","valor":"4.50","status":"1"}';
//$data_string = '{"tipo":"1","descricao":"Entrada Tortas","id_usuario":"1","id_pessoa":"1","id_emp":"1"}';
//$data_string = '{"id_mov":"1","consulta":""}';
//$data_string = '{"id_mov":"1","id_item":"1","qt":"5","valor":"2.50"}';
//$data_string = '{"id_im":"1","id_mov":"1","id_item":"1","qt":"5","valor":"2.50"}';
//$data_string = '{"modulo":"empresa","id_index_main":"1", "valor_id_main":"1", "id_tabela":"id_emp", "valor_id":"1", "estrutura":{"fantasia":"teste","razao":"novo teste","status":"1"}, "consulta":"", "limit":"2,5"}';
$data_string = '{"modulo":"mov_estoque m","id_index_main":"m.id_emp","valor_id_main":1,"id_tabela":"id_mov","valor_id":"","estrutura":{"":""},"campos":"m.id_mov,m.tipo,DATE_FORMAT(m.data,'%d/%m/%Y %H:%i')as data,m.descricao,m.id_usuario,m.id_pessoa,m.id_emp,p.nome_comp as pessoa,u.nome as usuario","inner_join":{"0":"usuarios u on m.id_usuario = u.id_usuario"},"left_join":{"0":"pessoas p on m.id_pessoa = p.id_pessoa"},"consulta":" and m.tipo = 1 and m.data BETWEEN '2016-1-9 00:00' and '2016-1-9 23:59'","limit":"0,15","nomeImg":""}';
//print_r(json_decode($data_string,true));
//http://ecold.alan.dev/ecold/consulta

$ch = curl_init('http://ecold.alan.dev/ecold/consulta');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   

echo  curl_exec($ch);

