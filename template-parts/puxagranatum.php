<?php
include( 'variaveis_datas.php' );
 


/********** PEGA A CHAVE DA API DO GRANATUM*************/
$chave_granatum = get_field('chave_granatum', 'option');

/********** CONTAS *************/


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/contas?access_token='.$chave_granatum);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$contas = json_decode($result, true);

curl_close($ch);



/********** CENTROS DE CUSTO *************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/centros_custo_lucro?access_token='.$chave_granatum);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$centros_custo_lucro = json_decode($result, true);

curl_close($ch);


$centros_custo_oni = [];
foreach($centros_custo_lucro as $value){
    if($value['descricao'] == 'ONI'){
        array_push($centros_custo_oni, $value['id'] );
        foreach($value['centros_custo_lucro_filhos'] as $centro_filho){
            array_push($centros_custo_oni, $centro_filho['id'] );
        }
    }
}



/********** CATEGORIAS *************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/categorias?access_token='.$chave_granatum);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );


$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$categorias = json_decode($result, true);
curl_close($ch);

$categorias_faturamento = array();
foreach($categorias as $categoria){
    if($categoria['id'] == '210706'){
        foreach($categoria['categorias_filhas'] as $faturamento){
            array_push(  $categorias_faturamento, $faturamento['id']);
        }
       
    }
}
/**
 * Construindo o array de reembolsos
 *
 * @return Array  com todos os reembolsos do período
 * @param Array
 *  [
 *  'id'    => (string) ID do usuário no granatum
 *  'nome'  => (string) nome e sobrenome do usuário do granatum
 *  'valor' => (int) valor somado de todos os lancamentos
 *  'gastos' => (array) com a lista dos gastos
 *      [
 *      (string) descrição do lançamento granatum + R$ + valor do lançamento
 *      ]
 *  ]   
 */
$reembolsos_onis = [];
foreach($categorias as $value){
    if($value['descricao'] == 'Reembolsos'){
        
        foreach($value['categorias_filhas'] as $reembolso_filho){
            array_push($reembolsos_onis, array(
                'id' => $reembolso_filho['id'],
                'nome' => $reembolso_filho['descricao'] ,
                'valor' => 0,
                'gastos'  => array(),               
            ));
        }
    }
}

/********** CONTAGEM DE LANCAMENTOS DO CARTÃO *************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$chave_granatum);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_POSTFIELDS, "conta_id=55632&data_inicio=".$p_dia."&data_fim=".$h_dia."&tipo_view=count");
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$n_lancamentos_cartao = json_decode($result, true);

curl_close($ch);



/********** CONTAGEM DE LANCAMENTOS DA CONTA *************/

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$chave_granatum);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_POSTFIELDS, "conta_id=39820&data_inicio=".$p_dia."&data_fim=".$h_dia."&tipo_view=count");
curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$n_lancamentos_conta = json_decode($result, true);

curl_close($ch);


/********** CONTAGEM DE LANCAMENTOS DA CONTA *************/
$n_lancamentos = $n_lancamentos_cartao[0] + $n_lancamentos_conta[0];



/********** MULTICURL POR CARTÃO *************/

$n_paginas = ceil($n_lancamentos/50);


$chs = [];
$responses_cartao = [];
$mh = curl_multi_init();
$running = null;
$i = 0;
while($i <= $n_paginas):
    $chs[$i] = curl_init();
    curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$chave_granatum);
    curl_setopt($chs[$i], CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chs[$i], CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($chs[$i], CURLOPT_POSTFIELDS, "conta_id=55632&data_inicio=".$p_dia."&data_fim=".$h_dia."&start=".$i*50);
    curl_setopt($chs[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($chs[$i], CURLOPT_HTTPHEADER, $headers);

    curl_multi_add_handle($mh, $chs[$i]);

    $i++;

endwhile;


do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh);
} while($running > 0);
foreach ($chs as $key => $ch) {
    if (curl_errno($ch)) {
        $responses_cartao[$key] = curl_error($ch);
    } else {
        $responses_cartao[$key] =  curl_multi_getcontent($ch);
    }
    curl_multi_remove_handle($mh, $ch);
}
curl_multi_close($mh);


/********** MULTICURL POR CONTA *************/

$n_paginas = ceil($n_lancamentos/50);


$chs = [];
$responses_conta = [];
$mh = curl_multi_init();
$running = null;
$i = 0;
while($i <= $n_paginas):
    $chs[$i] = curl_init();
    curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token='.$chave_granatum);
    curl_setopt($chs[$i], CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($chs[$i], CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($chs[$i], CURLOPT_POSTFIELDS, "conta_id=39820&data_inicio=".$p_dia."&data_fim=".$h_dia."&start=".$i*50);
    curl_setopt($chs[$i], CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($chs[$i], CURLOPT_HTTPHEADER, $headers);

    curl_multi_add_handle($mh, $chs[$i]);

    $i++;

endwhile;


do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh);
} while($running > 0);
foreach ($chs as $key => $ch) {
    if (curl_errno($ch)) {
        $responses_conta[$key] = curl_error($ch);
    } else {
        $responses_conta[$key] =  curl_multi_getcontent($ch);
    }
    curl_multi_remove_handle($mh, $ch);
}
curl_multi_close($mh);


$responses = array_merge($responses_cartao,$responses_conta);

$receitas = 0;
$despesas = 0;
$custos_de_projeto = 0;
$count = 0;
foreach($responses as $response):
    $pulses_pagina = json_decode($response);
    foreach($pulses_pagina as $lancamento):
        
        $p_dia_date = strtotime($p_dia);
        $u_dia_date = strtotime($u_dia);
        $h_dia_date = strtotime($h_dia);
        $data_competencia = strtotime($lancamento->data_competencia);
        $data_vencimento = strtotime($lancamento->data_vencimento);
        if($p_dia_date <= $data_competencia){
            if($u_dia_date >= $data_competencia ){
            //if($u_dia_date >= $data_vencimento || $u_dia_date >= $data_competencia ){
                if(array_search('11667', array_column($lancamento->tags, 'id')) !== false){
              
                }else{
                    $valor = floatval($lancamento->valor);
            
                    if($valor > 0 ):
                
                        if(in_array( $lancamento->categoria_id, $categorias_faturamento)){
                            $receitas += $lancamento->valor; 

                
                        };
                    elseif($valor < 0 ):
                        if($u_dia_date >= $data_vencimento ){
                            $despesas += $lancamento->valor;
                        }
                        
                        if(!in_array($lancamento->centro_custo_lucro_id, $centros_custo_oni) && ($lancamento->categoria_id != '229974')){
            
            
                            $custos_de_projeto += $lancamento->valor;
                        }
            
                    
                    endif;
                    if(in_array($lancamento->categoria_id, array_column($reembolsos_onis, 'id'))){
                        $id_reembolso = array_search($lancamento->categoria_id , array_column($reembolsos_onis, 'id')); 
                        $reembolsos_onis[$id_reembolso]['valor'] += $lancamento->valor;
                        $reembolsos_onis[$id_reembolso]['gastos'][] = $lancamento->descricao." : R$ ".number_format($lancamento->valor, 2, ',','.');
                    }
                    
                    $count ++;
                }
                
                
            }
         
        };
    
        

    endforeach;

endforeach;
$folha = round(($receitas+$custos_de_projeto)*0.55 , 2);
echo "<pre>";
var_dump($folha);
echo "</pre>";
$saldo = $receitas+$despesas;
echo "<pre>";
var_dump($saldo);
echo "</pre>";



// Pegando todos os usuários do wordpress
$onis = get_users();
foreach($onis as $oni){
    $valor_de_reembolso=0;
    echo "[".$oni->ID."] ".$oni->display_name." é ".$oni->roles[0]."</br>";
    // Puxando o valor do reembolso do array de reembolsos utilizando o nome e sobrenome como search
    $id_do_granatum = get_field('id_do_granatum', 'user_'.$oni->ID);
    if($id_do_granatum){
        $ir = array_search($id_do_granatum, array_column($reembolsos_onis, 'id'));
        $valor_de_reembolso = $reembolsos_onis[$ir]['valor'];;
        echo $valor_de_reembolso;
    }

    // Puxando as evidências
    $args = array(
        'numberposts'	=> -1,
        'post_type'		=> 'evidencias',
        'meta_key'		=> 'oni',
        'meta_value'	=> $oni->ID
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
        echo "<pre>";
        var_dump($post);
        echo "</pre>";
        wp_reset_query();
    endwhile;endif; 
 


}

echo "<div class='grid-x card'>";
echo "<p class='cell large-18 escala0'><strong class='petro'>Data inicial : </strong> ". $p_dia."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Data final : </strong> ". $u_dia."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Dias úteis : </strong> ". $dias_uteis."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Receitas (- Fora da folha) : </strong> R$ ". number_format($receitas, 2, ',','.')."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Despesas : </strong> R$ ". number_format($despesas, 2, ',','.')."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Saldo : </strong> R$ ".number_format($saldo, 2, ',','.')."</p>";  
echo "<p class='cell large-18 escala0'><strong class='petro'>Custos de projeto : </strong> R$ ".number_format($custos_de_projeto, 2, ',','.')."</p>"; 
echo "<p class='cell large-18 escala0'><strong class='petro'>Folha : </strong> R$".number_format($folha, 2, ',','.')."</p>"; 
echo "</div>";


?>



