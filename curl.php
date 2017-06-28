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
 $data_string = '{"db":"base_inicial","modulo":"usuarios u","id_index_main":"1","valor_id_main":"1","id_tabela":"u.id_usuario","valor_id":"","estrutura":{"":""},"campos":"","inner_join":"","left_join":"","order by":"","group by":"","consulta":"","limit":"0,5","nomeImg":""}';
//$data_string = '{"hottok": "uCNfzvAp5kqScMWMPDNSQ9jjp9Drsm182956","prod": "141775","callback_type":"1","status":"Aprovado","xcod":"21","name_subscription_plan":"locdress_mb"}';
//print_r(json_decode($data_string,true));
//http://ecold.alan.dev/ecold/consulta
//$data_string = '{"name":"Jorge Alan","email":"jalan.alves@gmail.com","dayOfCycle":1,"campaign":{"campaignId":63828503},"customFieldValues":[{"customFieldId":"id_emp","value":21}]}';

$ch = curl_init('http://mucontratos.alan.dev/v1/consulta');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

//curl_setopt($ch, CURLOPT_USERPWD, 'anystring:f222ad436ca8ee3fd14abe183d76f9e4-us10');

$headers = [
    'Content-Type: application/json'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

echo curl_exec($ch);


