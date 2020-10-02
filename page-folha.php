<?php
/*
Template Name: Folha
*/


?>
<?php get_header(); 
 
    $primeiro_dia_mes_passado = strtotime("first day of last month");
    $ultimo_dia_mes_passado = strtotime("last day of last month");
    $p_dia = date('Y-m-d', $primeiro_dia_mes_passado);
    $u_dia = date('Y-m-d', $ultimo_dia_mes_passado);

if (!empty($_POST['form_action'])){
    $p_dia = $_POST['data_inicial'];
    $u_dia = $_POST['data_final'];
    $h_dia = $_POST['data_final'];
}   
    $u_dia_date= strtotime($u_dia);
    $uu_dia = strtotime("last day of next month",$u_dia_date);
    $h_dia = date('Y-m-d', $uu_dia);

 
/********** DIAS *************/


$dias_uteis = getWorkdays(strtotime($p_dia), strtotime($u_dia));

/********** CONTAS *************/


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/contas?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/centros_custo_lucro?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/categorias?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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

curl_setopt($ch, CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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
    curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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
    curl_setopt($chs[$i], CURLOPT_URL, 'https://api.granatum.com.br/v1/lancamentos?access_token=3ba65c05142ae3896005fea29d67dffb9390dbf1ad3eeb9cfd53a1f4a14a2c22');
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
$saldo = $receitas+$despesas;


/************************ SETANDO HEADER DE CONEXÕES **************************************/
$token = 'eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjM5NDU4MzY0LCJ1aWQiOjEzMDAxNjcyLCJpYWQiOiIyMDIwLTAzLTA2IDE1OjEwOjI2IFVUQyIsInBlciI6Im1lOndyaXRlIn0.YdtzY5MoDAGtvnyP7KrOEwaoJ-Gz04h6fjJeT6dlrxs';
$tempUrl = "https://oni.monday.com/v2/";
$headers = ['Content-Type: application/json', 'Authorization: ' . $token];

/************************ FAZENDO QUERY DE TODOS OS BOARDS **************************************/
$query = '  {
                boards(
                    limit: 999
                ){
                    id
                    name
                }
            }';
$data = @file_get_contents($tempUrl, false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => $headers,
        'content' => json_encode(['query' => $query]),
    ]
]));
$Contents = json_decode($data, true);

/************************ FAZENDO QUERY DE TODOS OS USUÁRIOS **************************************/
$query = '  {
    users(
        kind: non_guests
    ){
        name
        id
        photo_thumb
        teams {
            name
        }
    }

}';
$data = @file_get_contents($tempUrl, false, stream_context_create([
'http' => [
'method' => 'POST',
'header' => $headers,
'content' => json_encode(['query' => $query]),
]
]));

$usuarios = json_decode($data, true);

$socios = array('Barbara Duavy', 'Henrique Ayres', 'Herick Ferreira','Thiago Ramiro');
$onis = array();
foreach($socios as $socio):
    $onis[$socio] = array(
        'id' => '',
        'foto' => '',
        'nome' => $socio,
        'teams' => array( 0 => array( 'name' => 'Sócios')),
        'ferias' => 0,
        'ferias_tres_meses' => 0,
        'guarda' => 0,
        'mao_direita' => 0,
        'competencias' => array(),
        'onions_competencia' => 0,
        'onions_competencia_dia' => 0,
        'onions_papeis' => 0,
        'onions_papeis_dia' => 0,
        'onions_descontados' => 0,
        'advertencias' => 0,
        'explicacoes_advertencias' => array(),
        'remuneracao' => 0,
        'reembolsos' => 0,
        'feedback_guardas' => array(),
        'guardas_explicacao' => array(),
        'tabela_guardas' => "",
        'projetos_mao_direita' => array(),
    );
endforeach;


foreach($usuarios['data']['users'] as $key => $user):
    $onis[$user['name']] = array(
        'id' => $user['id'],
        'foto' => $user['photo_thumb'],
        'nome' => $user['name'],
        'teams' => $user['teams'],
        'ferias' => 0,
        'ferias_tres_meses' => 0,
        'guarda' => 0,
        'mao_direita' => 0,
        'competencias' => array(),
        'onions_competencia' => 0,
        'onions_competencia_dia' => 0,
        'onions_papeis' => 0,
        'onions_papeis_dia' => 0,
        'onions_descontados' => 0,
        'advertencias' => 0,
        'explicacoes_advertencias' => array(),
        'remuneracao' => 0,
        'reembolsos' => 0,
        'feedback_guardas' => array(),
        'guardas_explicacao' => array(),
        'tabela_guardas' => "",
        'projetos_mao_direita' => array(),
    );
endforeach;

$equivalencia_guardas = array(
    0 => "Cu na reta",
    1 => "Suporte estratégico aos envolvidos",
    2 => "Forecast (gestão estratégica)",
    3 => "Definir passos e seus escopos (gestão tática)",
    4 => "Ritmo de projeto e entrega de valor",
    5 => "Escolher e gerir equipe de projeto",
    6 => "Gerir missões (gestão operacional)",
    7 => "Comunicação de projeto com cliente",

);
$equivalencia_status_guardas = array(
    1 => "Fez",
    2 => "Falhou",
    10 => "Não precisou"

);
?>




































<div class='grid-x grid-padding-x  '>
    <div class='cell large-5' >
        <form method="post" action="" class='grid-x card ' style='padding-bottom:2em;'>
            <p class='cell large-9 ' >Data inicial:
                <input type="date" name="data_inicial" value="<?php echo $p_dia ?>">
            </p>
            <p class='cell large-9 ' >Data final:
                <input class='cell large-18'  type="date" name="data_final" value="<?php echo $u_dia ?>">
            </p>
            <input class='cell large-18 '  name="form_action[Filtrar]" type="submit" value="Filtrar">
            <select name="filtra-oni" onchange="showHideInput(this)" class='cell large-18'>
                <option value="todos" >Todos</option>
                <?php 
                    foreach($onis as $oni){
                        echo "<option value=".$oni['nome'].">".$oni['nome']."</option>";
                    };
                ?>
            </select>
            <input class='cell large-18 submit_pink'  name="form_action[Salvar]" type="submit" value="Salvar"  onclick="return confirm('Você quer consolidar a folha??');">
            
        </form> 

        <?php



        /************************ ONIONS POR PESSOA **************************************/
        echo "<div class='grid-x card'>";
            echo "<p class='cell large-18 escala0'><strong class='petro'>Data inicial : </strong> ". $p_dia."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Data final : </strong> ". $u_dia."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Dias úteis : </strong> ". $dias_uteis."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Receitas (- Fora da folha) : </strong> R$ ". number_format($receitas, 2, ',','.')."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Despesas : </strong> R$ ". number_format($despesas, 2, ',','.')."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Saldo : </strong> R$ ".number_format($saldo, 2, ',','.')."</p>";  
            echo "<p class='cell large-18 escala0'><strong class='petro'>Custos de projeto : </strong> R$ ".number_format($custos_de_projeto, 2, ',','.')."</p>"; 
            echo "<p class='cell large-18 escala0'><strong class='petro'>Folha : </strong> R$".number_format($folha, 2, ',','.')."</p>"; 


            $onions_no_sistema = 0;
            $pulses_guardas = puxa_board_por_titulo($Contents, "Guardiões e Mãos direitas | Oni");

            $pulses_ferias = puxa_board_por_titulo($Contents, "Férias");

            $pulses_advertencias = puxa_board_por_titulo($Contents, "Advertências");

            $tres_meses = strtotime('-3 month',strtotime($u_dia));

            foreach($onis as $oni){
                if($oni['nome'] !== "Sócios"){
            
                    $ir = array_search($oni['nome'], array_column($reembolsos_onis, 'nome'));

                    $onis[$oni['nome']]['reembolsos'] += $reembolsos_onis[$ir]['valor'];
                    if(is_array($pulses_guardas)){
                        foreach($pulses_guardas as $projetos){
                            $vigencia = json_decode($projetos['column_values'][12]['value']);
                        
                            $data_vigencia = strtotime($vigencia->date);
                    
                            if(strtotime($p_dia) <= $data_vigencia && strtotime($u_dia) >= $data_vigencia ){
                                similar_text($oni['nome'], $projetos['column_values'][1]['value'], $similaridade_guarda);
                                similar_text($oni['nome'], $projetos['column_values'][11]['value'], $similaridade_mao_direita);
                            
                                if($similaridade_guarda > 80){
                                    for($i = 2; $i <= 9; $i++){
                                        $feedbacks[$projetos['name'].$oni['nome']][] = json_decode($projetos['column_values'][$i]['value'])->index;
                                    };
                                    $onis[$oni['nome']]['guarda'] += 1;
                                    $onis[$oni['nome']]['onions_papeis'] += str_replace('"', "",  $projetos['column_values'][10]['value']);
                                    $onis[$oni['nome']]['feedback_guardas'][] =  array(
                                        'projeto' => $projetos['name'],
                                        'feedbacks' => $feedbacks[$projetos['name'].$oni['nome']],
                                        'justificativas' => $projetos['updates'],
                                        'onions' => str_replace('"', "",  $projetos['column_values'][10]['value'])
                                    );
                                    
                                };
                                if($similaridade_mao_direita > 80){
                                    $onis[$oni['nome']]['mao_direita'] += 1;
                                    $onis[$oni['nome']]['projetos_mao_direita'][] = array( 'projeto_mao_direita' => $projetos['name']);
                                    $onis[$oni['nome']]['onions_papeis'] += 2;
                                };
                            };
                        };
                    }

                    if(in_array("Sócios", array_column($oni['teams'], 'name') ) ):
                        $onis[$oni['nome']]['onions_competencias'] = 120;
                    elseif(in_array("Trainee", array_column($oni['teams'], 'name') ) ):
                        $onis[$oni['nome']]['onions_competencias'] = 20;
                    elseif(in_array("Stags", array_column($oni['teams'], 'name') ) ):
                        $onis[$oni['nome']]['remuneracao'] = 950;
                    elseif(in_array("Admin", array_column($oni['teams'], 'name') ) ):
                    endif;
                
                    
                        $pulses_competencias = puxa_board_competencias($Contents,$oni['nome']);
                    
                        $equivalencia = array(0 => 0, 1 => 1, 2 => 2, 3 => 4, 4 => 6, 5 => 8);
                        if(is_array($pulses_competencias)){
                            
                            foreach($pulses_competencias as $competencia){ 
                                
                                
                                $vigencia = json_decode($competencia['column_values'][2]['value']);
                                $data_vigencia = strtotime($vigencia->date);
                                if(strtotime($p_dia) <= $data_vigencia && strtotime($u_dia) >= $data_vigencia ){
                                
                                    $atributo = false; 
                                    $nome_competencia = $competencia['name']." : ";
                                    if($competencia['name'] == "[Atributos]"){
                                        $atributo = true;
                                    }
                                    foreach($competencia['column_values'] as $valores){
                                        if($valores['id'] == 'rating'){
                                            $rating = json_decode($valores['value'], true);
                                            if($rating['rating'] == NULL){
                                                $rating['rating'] = 0;
                                            }
                                            
                                            $onion = 0;
                                            $onion += $equivalencia[$rating['rating']];
                                            $esfera = substr(strtok($nome_competencia, ']'), 1);
                                            $competencia  = substr(substr( $nome_competencia, strpos($nome_competencia, '] ')) ,2 , -3);
                                            $onis[$oni['nome']]['competencias'][] =  array(
                                                'esfera' => $esfera,
                                                'competencia' => $competencia,
                                                'nivel' => $rating['rating']
                                            );
                                            
                                            if(in_array("Onis", array_column($oni['teams'], 'name') ) && !in_array("Trainee", array_column($oni['teams'], 'name') ) ):
                                            

                                                $onis[$oni['nome']]['onions_competencias'] += $onion;
                                            endif;
                                        };  
                                    };
                                };
                            
                            };
                        }
                    
                    if(is_array($pulses_ferias)){
                        foreach($pulses_ferias as $ferias){
                            similar_text($oni['nome'], $ferias['name'], $similaridade_ferias); 
                            if($similaridade_ferias > 80){
                                $data = json_decode($ferias['column_values'][1]['value']);
                                $data_ferias = strtotime($data->date);
                                if(($data_ferias > $tres_meses )  && ($data_ferias <= strtotime($u_dia))){
                                    $dias_ferias = str_replace('"', "",  $ferias['column_values'][0]['value']);
                                    if($dias_ferias == NULL){
                                        $dias_ferias = 0;
                                    }
                                    
                                        $onis[$oni['nome']]['ferias_tres_meses'] += $dias_ferias;
                                    
                                    if(($data_ferias >= strtotime($p_dia)) && ($data_ferias <= strtotime($u_dia))  ){ 
                                        $onis[$oni['nome']]['ferias'] += $dias_ferias;
                                    };
                                };
                                
                            };
                        };
                    }
                    if(is_array($pulses_advertencias)){
                        foreach($pulses_advertencias as $advertencia){
                            similar_text($oni['nome'], $advertencia['name'], $similaridade_advertencia); 
                            if($similaridade_advertencia > 80){
                                $data = json_decode($advertencia['column_values'][0]['value']);
                                $explicacao = json_decode($advertencia['column_values'][1]['value']);
                                $data_advertencia = strtotime($data->date);                              
                                if(($data_advertencia >= strtotime($p_dia)) && ($data_advertencia <= strtotime($u_dia))  ){ 
                                    $onis[$oni['nome']]['advertencias']++;
                                    $onis[$oni['nome']]['explicacoes_advertencias'][] = array( 'explicacao_advertencia' => $explicacao->text); 
                                }
                                        
                            };
                        };
                    }
                    
                    $onis[$oni['nome']]['onions_competencia_dia'] = round($onis[$oni['nome']]['onions_competencias']/$dias_uteis, 2);
                    $onis[$oni['nome']]['onions_papeis_dia'] = round($onis[$oni['nome']]['onions_papeis']/$dias_uteis, 2);
                    if($onis[$oni['nome']]['ferias_tres_meses'] > 4){
                        $onis[$oni['nome']]['onions_descontados'] =
                            round(0.33*($onis[$oni['nome']]['onions_competencia_dia'] * $onis[$oni['nome']]['ferias']) +
                            $onis[$oni['nome']]['onions_papeis_dia'] * $onis[$oni['nome']]['ferias'], 2);
                                
                    }
                    
                    $onis[$oni['nome']]['onions_descontados'] += $onis[$oni['nome']]['advertencias'];
                    
                    $onions_no_sistema += $onis[$oni['nome']]['onions_competencias'] + $onis[$oni['nome']]['onions_papeis'] - $onis[$oni['nome']]['onions_descontados'];
                }

            }



            $valor_do_onion = round($folha/$onions_no_sistema , 2);
            echo "<p class='cell large-18 escala1'><strong class='pink'>Onions no sistema :</strong> ".$onions_no_sistema."</p>";
            echo "<p class='cell large-18 escala1'><strong class='pink'>Valor do Onion :</strong> R$ ".number_format($valor_do_onion, 2, ',','.')."</p>";
        echo "</div>";
        ?>
 
        <?php


    echo "</div>";

    



    echo "<div class='cell large-13'>";
        foreach($onis as $oni){
            if($oni['nome'] !== "Sócios"){
                echo "<div class='recibo-oni card' id=".$oni['nome'].">";
                    echo "<h3>".$oni['nome']."</h3></br>";
                    echo "<p class='escala0'><strong class='pink'>Guardas : </strong>".$onis[$oni['nome']]['guarda']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Mãos direitas : </strong>".$onis[$oni['nome']]['mao_direita']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Onions de envolvimento : </strong>".$onis[$oni['nome']]['onions_papeis']." <span class='pink'>(R$ ".number_format($onis[$oni['nome']]['onions_papeis']*$valor_do_onion, 2, ',','.').")</span></p>";
                    echo "<p class='escala0'><strong class='pink'>Onions de competências: </strong>".$onis[$oni['nome']]['onions_competencias']." <span class='pink'>(R$ ".number_format($onis[$oni['nome']]['onions_competencias']*$valor_do_onion, 2, ',','.').")</span></p>";
                    echo "<p class='escala0'><strong class='pink'>Total de Onions: </strong>".($onis[$oni['nome']]['onions_competencias']+$onis[$oni['nome']]['onions_papeis'])." <span class='pink'>(R$ ".number_format(($onis[$oni['nome']]['onions_competencias']+$onis[$oni['nome']]['onions_papeis'])*$valor_do_onion, 2, ',','.').")</span></p>"; 
                    echo "<p class='escala0'><strong class='pink'>Dias de ausência: </strong>".$onis[$oni['nome']]['ferias']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Dias de ausência nos últimos 3 meses : </strong>".$onis[$oni['nome']]['ferias_tres_meses']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Onion competência dia:</strong> ".$onis[$oni['nome']]['onions_competencia_dia']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Onion papéis dia: </strong>".$onis[$oni['nome']]['onions_papeis_dia']."</p>";
                    echo "<p class='escala0'><strong class='pink'>Onions descontados: </strong>".$onis[$oni['nome']]['onions_descontados']." <span class='pink'>(R$".number_format(($onis[$oni['nome']]['onions_descontados']*$valor_do_onion), 2, ',','.').")</span></p>";
                    if(is_array($onis[$oni['nome']]['explicacoes_advertencias'])){
                        foreach($onis[$oni['nome']]['explicacoes_advertencias'] as $explicacao_advertencia){
                            echo "<p class='escala0'><em>".$explicacao_advertencia['explicacao_advertencia']."</em></p>";
                            
                        }

                    }
                    if(!in_array("Stags", array_column($oni['teams'], 'name') ) ){
                        $onis[$oni['nome']]['remuneracao'] =
                            
                            $onis[$oni['nome']]['onions_papeis']*$valor_do_onion +
                            $onis[$oni['nome']]['onions_competencias']*$valor_do_onion - 
                            $onis[$oni['nome']]['onions_descontados']*$valor_do_onion -
                            $onis[$oni['nome']]['reembolsos'];
                        
                    }else{
                        $onis[$oni['nome']]['remuneracao'] -=
                            $onis[$oni['nome']]['reembolsos'];
                    }
                    echo "<p class='escala0'><strong class='pink'>Reembolsos :</strong> R$".$onis[$oni['nome']]['reembolsos']."</p>";
                
                    foreach($reembolsos_onis as $reembolso){
                        if($reembolso['nome'] == $oni['nome']){
                            foreach($reembolso['gastos'] as $item){
                                echo "<p class='escala0'><em>".$item."</em></p>";
                            }

                        }
                    }
                    
                    echo "<p class='escala1'><strong class='pink'>Remuneração :</strong> R$".number_format($onis[$oni['nome']]['remuneracao'], 2, ',','.')."</p>";
                    if($onis[$oni['nome']]['guarda'] > 0){
                        $onis[$oni['nome']]['tabela_guarda'] .= '
                        <table style="text-align: center; ">
                            <tr> 
                                <th> Projeto </th>
                                ';
                                foreach($equivalencia_guardas as $traco_guarda){
                                    $onis[$oni['nome']]['tabela_guarda'] .=  "<th>".$traco_guarda."</th>";
                                };
                            foreach($onis[$oni['nome']]['feedback_guardas'] as $feedback_guarda){
                                $justificativas = '';
                                $onis[$oni['nome']]['tabela_guarda'] .=  "<tr>";
                                $onis[$oni['nome']]['tabela_guarda'] .=  "<td class='escala0'>".$feedback_guarda['projeto']."</td>";
                                        foreach($feedback_guarda['feedbacks'] as $key => $feedbacks){
                                            $onis[$oni['nome']]['tabela_guarda'] .=  "<td class='escala0 status".$feedbacks."'>".$equivalencia_status_guardas[$feedbacks]." </td>";
                                        }
                                        $onis[$oni['nome']]['tabela_guarda'] .=  "</tr>";
                                    foreach($feedback_guarda['justificativas'] as $justificativa){
                                        if (strpos($justificativa['text_body'], 'duplicated an Item') !== false || strpos($justificativa['text_body'], 'renamed the item') !== false  || strpos($justificativa['text_body'], 'created a new Item') !== false){
                                            
                                        }else{
                                            $onis[$oni['nome']]['tabela_guarda'] .=  "<tr >";
                                            $onis[$oni['nome']]['tabela_guarda'] .=  "<td></td>";
                                            $onis[$oni['nome']]['tabela_guarda'] .=  "<td colspan=8 ><em class='escala0'>".$justificativa['text_body']." </em></td>";
                                            $onis[$oni['nome']]['tabela_guarda'] .=  "</tr>";
                                            $justificativas .= $justificativa['text_body'];
                                        }
                                        
                                    }
                                    $onis[$oni['nome']]['guardas_explicacao'][] = array(
                                        'projeto' => $feedback_guarda['projeto'],
                                        "cu_na_reta" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][0]],
                                        "suporte_estrategico_aos_envolvidos" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][1]],
                                        "forecast_gestao_estrategica" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][2]],
                                        "definir_passos_e_seus_escopos_gestao_tatica" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][3]],
                                        "ritmo_de_projeto_e_entrega_de_valor" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][4]],
                                        "escolher_e_gerir_equipe_de_projeto" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][5]],
                                        "gerir_missoes_gestao_operacional" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][6]],
                                        "comunicacao_de_projeto_com_cliente" => $equivalencia_status_guardas[$feedback_guarda['feedbacks'][7]],
                                        'justificativas' => $justificativas,
                                        'onions' => $feedback_guarda['onions']
                                    );
                                    
                            }
                
                            $onis[$oni['nome']]['tabela_guarda'] .= '</table>';
                        echo $onis[$oni['nome']]['tabela_guarda'];
                        
                    
                    
                    }

        
            echo "</div>";
        }	
    }
echo "</div>";


if (!empty($_POST['form_action']['Salvar'])){
    echo "Salvando os registros";
    $ano_mes = substr($u_dia, 0 , 7);
    // WP_Query arguments
    $args = array (
        'post_type'              => array( 'pagamentos' ),
        'post_status'            => array( 'publish' ),
        'nopaging'               => true,
        's' => $ano_mes
    );

    // The Query
    $pagamentos = new WP_Query( $args );

    // The Loop
    if ( $pagamentos->have_posts() ) {
       
            echo "já está salvo";
    } else {
        

        foreach($onis as $oni){
            $detalhamento_reembolso = "";
            foreach($reembolsos_onis as $reembolso){
                if($reembolso['nome'] == $oni['nome']){
                    foreach($reembolso['gastos'] as $item){
                        $detalhamento_reembolso .= "<p>".$item."</p>";
                    }
        
                }
            }
                $my_post = array(
                    'post_title' => $oni['nome']." | ".$ano_mes,
                    'post_status' => 'publish',
                    'post_type' => 'pagamentos',
                );
            
            $post_id = wp_insert_post($my_post);
           update_field('data', $ano_mes, $post_id);
           update_field('oni', $oni['nome'], $post_id);
           update_field('guardas', $onis[$oni['nome']]['guarda'], $post_id);
           update_field('maos_direitas', $onis[$oni['nome']]['mao_direita'] , $post_id);
           update_field('onions_de_envolvimento', $onis[$oni['nome']]['onions_papeis'] , $post_id);
           update_field('onions_de_competencias', $onis[$oni['nome']]['onions_competencias'] , $post_id);
           update_field('total_de_onions', ($onis[$oni['nome']]['onions_competencias']+$onis[$oni['nome']]['onions_papeis']) , $post_id);
           update_field('dias_de_ausencia', $onis[$oni['nome']]['ferias'] , $post_id);
           update_field('dias_de_ausencias_nos_3_meses_anteriores', $onis[$oni['nome']]['ferias_tres_meses'] , $post_id);
           update_field('onions_competencia_dia', $onis[$oni['nome']]['onions_competencia_dia'] , $post_id);
           update_field('onion_papeis_dia', $onis[$oni['nome']]['onions_papeis_dia'] , $post_id);
           update_field('onions_descontados', $onis[$oni['nome']]['onions_descontados'] , $post_id);
           update_field('explicacoes_descontos', $onis[$oni['nome']]['explicacoes_advertencias'] , $post_id);
           update_field('valor_reembolsos', $onis[$oni['nome']]['reembolsos'] , $post_id);
           update_field('reembolsos', $detalhamento_reembolso , $post_id);
           update_field('remuneracao', $onis[$oni['nome']]['remuneracao'] , $post_id);
           update_field('guardas_explicacao', $onis[$oni['nome']]['guardas_explicacao'] , $post_id);
           update_field('tabela_guarda', $onis[$oni['nome']]['tabela_guarda'] , $post_id);
           update_field('competencias', $onis[$oni['nome']]['competencias'] , $post_id);
           update_field('projetos_mao_direita', $onis[$oni['nome']]['projetos_mao_direita'] , $post_id);
           update_field('valor_do_onion', $valor_do_onion , $post_id);
                
            }
    }

    // Restore original Post Data
    wp_reset_postdata();

   
        


        echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
    } 




?>
<script>
function showHideInput(sel) {
    var recibos = document.getElementsByClassName("recibo-oni");
    var value = sel.value;  
    if(value=='Todos') {
        for (var i = 0; i < recibos.length; ++i) {
            
            recibos[i].style.display = 'block';
            
        }
    } else{
        for (var i = 0; i < recibos.length; ++i) {
            recibos[i].style.display = "none";
        }
        document.getElementById(value).style.display = 'block';
    }
        
};

</script>

<?php get_footer(); ?>
