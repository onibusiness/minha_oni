<?php

/*
* Faz o processamento da folha
*
*/
class processa_folha{
    public $reembolsos_onis = [];// reembolsos por oni
    public $centros_custo_oni = [];//centos de custo da Oni
    public $categorias_faturamento = array();//categorias de faturamento dos projetos
    public $receitas = 0; //receitas do período
    public $despesas = 0; //despesas do período
    public $custos_de_projeto = 0; //custos de projeto do período
    public $budget_folha = 0;// budget da folha
    public $onis; //array de onis 
    public $onions_competencia = 0; //numero de onions de competencia no sistema
    public $onions_papeis = 0; //numero de onions de papeis no sistema
    public $onions_advertencias = 0; //numero de onions de advertencias tomadas no sistema
    public $onions_ferias= 0; //numero de onions redistribuidos por férias
    public $onions_no_sistema = 0; //numero de onions no sistema
    public $folha; //array com a folha fechada por Oni    
    public $valor_do_onion; //valor do onion   
    
    
    private $alerts; //guardando todos os alerts da requisição

    //disparando a classe
    public function __construct(){
        //inserindo todos os custom post types        
        require_once('granatum_class.php');
        //criando o array reembolsos
        $this->setaReembolsos($granatum->categorias);
        //montandos os centros de custo
        $this->montaCentroCustoOni($granatum->centros_custo_lucro);
        //pegando as categorias de faturamento
        $this->pegaCategoriasFaturamento($granatum->categorias);
        // processa o financeiro
        $this->processaFinanceiro($granatum->lancamentos_cartao, $granatum->lancamentos_conta, $granatum->p_dia, $granatum->u_dia );

        // monta o array dos onis
        $this->montaOnis( $granatum->p_dia, $granatum->u_dia);

        // conta os Onions do sistema
        $this->contaOnions($granatum->p_dia, $granatum->u_dia);

        // fecha a folha
        $this->fechaFolha();
    }

    /**
    * Construindo o array de reembolsos
    *
    * @return Array  com a estrutura de reembolso por oni, para receber os valores depois
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
    public function setaReembolsos($categorias){
        foreach($categorias as $value){
            if($value['descricao'] == 'Reembolsos'){
                
                foreach($value['categorias_filhas'] as $reembolso_filho){
                    array_push($this->reembolsos_onis, array(
                        'id' => $reembolso_filho['id'],
                        'nome' => $reembolso_filho['descricao'] ,
                        'valor' => 0,
                        'gastos'  => array(),               
                    ));
                }
            }
        }
    }
    /**
    * Checkando os centros de custo da oni
    *
    * @return Array  com os centros de custo da Oni
    * @param Array com todos os centros de custo do granatum
    *     
    */
    public function montaCentroCustoOni($centros_custo_lucro){
        foreach($centros_custo_lucro as $value){
            if($value['descricao'] == 'ONI'){
                array_push($this->centros_custo_oni, $value['id'] );
                foreach($value['centros_custo_lucro_filhos'] as $centro_filho){
                    array_push($this->centros_custo_oni, $centro_filho['id'] );
                }
            }
        }
    }

    /**
    * Pegando as categorias de faturamento da oni
    *
    * @return Array  com as categorias de faturamento da oni
    * @param Array com todos os as categorias vindas do granatum
    *     
    */
    public function pegaCategoriasFaturamento($categorias){
        foreach($categorias as $categoria){
            if($categoria['id'] == '210706'){
                foreach($categoria['categorias_filhas'] as $faturamento){
                    array_push(  $this->categorias_faturamento, $faturamento['id']);
                }
               
            }
        }
    }

    /**
    * Processa os dados financeiros vindos do granatum para setar os parâmetros do mês
    *
    * @return Mixed  Seta valores de reembolso, receitas, despesas e folha
    * @param Array $lancamentos_cartao | Json decoded com a resposta de lançamentos de cartão vindo do granatum 
    * @param Array $lancamentos_conta | Json decoded com a resposta de lançamentos de contas vindo do granatum
    * @param String $p_dia | 'Y-m-d' Com o primeiro dia do período
    * @param String $u_dia | 'Y-m-d' Com o último dia do período  
    *     
    */
    public function processaFinanceiro($lancamentos_cartao, $lancamentos_conta,$p_dia, $u_dia ){
        //criando um array com todos os lancamentos integrados
        $responses = array_merge($lancamentos_cartao,$lancamentos_conta);
        foreach($responses as $response):
            $pulses_pagina = json_decode($response);
            
            foreach($pulses_pagina as $lancamento):
            
                $p_dia_date = strtotime($p_dia);
                $u_dia_date = strtotime($u_dia);
                $data_competencia = strtotime($lancamento->data_competencia);
    
                $data_vencimento = strtotime($lancamento->data_vencimento);
                if($p_dia_date <= $data_competencia){
                    if($u_dia_date >= $data_competencia ){
                        
                        if(array_search('11667', array_column($lancamento->tags, 'id')) !== false){
                      
                        }else{
                            $valor = floatval($lancamento->valor);
                      
                            if($valor > 0 ):
                                if(in_array( $lancamento->categoria_id, $this->categorias_faturamento)){
                                    $this->receitas += $lancamento->valor; 
                                };
                            elseif($valor < 0 ):
                                if($u_dia_date >= $data_vencimento ){
                                    $this->despesas += $lancamento->valor;
                                }
                                
                                if(!in_array($lancamento->centro_custo_lucro_id, $this->centros_custo_oni) && ($lancamento->categoria_id != '229974')){
                    
                    
                                    $this->custos_de_projeto += $lancamento->valor;
                                }
                    
                            
                            endif;
                            if(in_array($lancamento->categoria_id, array_column($this->reembolsos_onis, 'id'))){
                                $id_reembolso = array_search($lancamento->categoria_id , array_column($this->reembolsos_onis, 'id')); 
                                $this->reembolsos_onis[$id_reembolso]['valor'] += $lancamento->valor;
                                $this->reembolsos_onis[$id_reembolso]['gastos'][] = $lancamento->descricao." : R$ ".number_format($lancamento->valor, 2, ',','.');
                            }
                            
                        }
                        
                        
                    }
                 
                };
            
                
        
            endforeach;
        
        endforeach;
        $this->budget_folha = round(($this->receitas+$this->custos_de_projeto)*0.55 , 2);

    
    }

    /**
    * Construindo o array dos Onis com os parâmetros para pagamentos
    *
    * @return Array $this->onis com os onis
    *   [$user->display_name]
    *       [
    *       'ID'    => (int) ID do wp
    *       'funcao'    => (string) funcao do usuário - stag - trainee - oni    
    *       'competencias'    => (array) Competências até a data
    *           [
    *           'pontos' => (int) Número de pontos da competencia
    *           'onion_up' => (bool) Se teve onion up no período
    *           ]
    *       'guardas'    => (array) Guardas no período
    *           [
    *           'papel' => (string) Tipo de guarda
    *           'projeto' => (string) nome do projeto
    *           'com_rodinhas' => (bool) Se a guarda é com rodinhas
    *           'percentual' => (int) Valor de 0 a 1 representando o percentual de dias que a guarda rodou no mês
    *           ]
    *       'ferias_desconto_padrao'    => (int) Dias úteis de férias com o desconto padrao
    *       'ferias_desconto_total'    => (int) Dias úteis de férias com o desconto total
    *       'ferias_tres_meses'    => (int) Dias úteis de férias nos útimos 3 meses
    *       'advertencias'    => (int) Número de advertências
    *       'explicacoes_advertencias'    => (array) Explicações das advertências tomadas
    *           [
    *           'data' => (date) Data da advertencia
    *           'explicacao' => (string) Explicação da advertência
    *           ]
    *       ]
  
    */
    public function montaOnis($p_dia, $u_dia){
        //Fazendo o loop por usuário cadastrado no minha.oni
        $users_wordpress = get_users();
        foreach($users_wordpress as $user){

            $this->onis[$user->display_name] = array(
                'ID' => $user->ID,
                'funcao' => key($user->caps),
                'competencias' => array(),
                'guardas' => array(),
                'ferias_desconto_padrao' => 0,
                'ferias_desconto_total' => 0,
                'ferias_tres_meses' => 0,
                'advertencias' => 0,
                'explicacoes_advertencias' => array()
            );
           


            // COMPETENCIAS - monta o array de competencias
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'competencias',
                'post_status'   => 'publish'
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $this->onis[$user->display_name]['competencias'][get_the_title()]['pontos'] = 0;
            endwhile;endif;
            wp_reset_query();

            // COMPETENCIAS - lendo todas as evoluções e montando competencias
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'evolucoes',
                'post_status'   => 'publish',
                'meta_key'		=> 'oni',
                'meta_value'	=> $user->ID
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $fields = get_fields();
                $competencia = get_field('competencia');
                $competencia = get_the_title($competencia);
                //preenchendo as competências com as evidências
                if($competencia !== NULL){
                    $this->onis[$user->display_name]['competencias'][$competencia]['pontos'] += 1;
                }  
                //Checkando se a evolução foi nesse mês
                $data_evolucao = str_replace('/', '-', $fields['data']);
                if((strtotime($data_evolucao) >= strtotime($p_dia)) && (strtotime($data_evolucao) <= strtotime($u_dia))){
                    $this->onis[$user->display_name]['competencias'][$competencia]['onion_up'] = 'true';
                }
            endwhile;endif;
            wp_reset_query();

            // GUARDAS - lendo as guardas
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'papeis',
                'post_status'   => 'publish',
                'meta_key'		=> 'oni',
                'meta_value'	=> $user->ID
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $fields = get_fields();
                //Pegando as datas da guarda
                $data_de_inicio_guarda = str_replace('/', '-', $fields['data_de_inicio']);
                $data_de_termino_guarda = str_replace('/', '-', $fields['data_de_terminio']);
                $dias_uteis_periodo=  minha_oni::contaDiasUteis( strtotime($p_dia), strtotime($u_dia)); 
                $dias_uteis_de_guarda = 0;//resetando os dias de guarda

                //Verificando se existe overlap entre a data do filtro e a data da guarda
                if(strtotime($data_de_inicio_guarda) <= strtotime($u_dia) && strtotime($data_de_termino_guarda) >= strtotime($p_dia)) {           
                    $overlap_data_inicial = max(strtotime($p_dia),strtotime($data_de_inicio_guarda)); //dia inicial do overlap                 
                    $overlap_data_final = min(strtotime($u_dia),strtotime($data_de_termino_guarda)); //dia final do overlap
                    $dias_uteis_de_guarda =  minha_oni::contaDiasUteis( $overlap_data_inicial, $overlap_data_final); //dias úteis no overlap
                    $percentual_guarda = round( $dias_uteis_de_guarda/$dias_uteis_periodo, 2); //proporção de dias no overlap x período
                    $this->onis[$user->display_name]['guardas'][] = array(
                        'papel' => $fields['papel'],
                        'projeto' => $fields['projeto'],
                        'com_rodinhas' => $fields['com_rodinhas'],
                        'percentual' => $percentual_guarda            
                    );
                }
            endwhile;endif;
            wp_reset_query();

            // FÉRIAS - lendo as férias
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'ferias',
                'post_status'   => 'publish',
                'meta_key'		=> 'oni',
                'meta_value'	=> $user->ID
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $fields = get_fields();
                //Pegando as datas das férias
                $primeiro_dia_fora = str_replace('/', '-', $fields['primeiro_dia_fora']);
                $ultimo_dia_fora = str_replace('/', '-', $fields['ultimo_dia_fora']);
                $dias_uteis_periodo=  minha_oni::contaDiasUteis( strtotime($p_dia), strtotime($u_dia));
                $tres_meses = strtotime('-3 month',strtotime($u_dia));//3 últimos meses 
                $dias_uteis_de_ferias_no_periodo = 0;//resetando os dias de férias
                $dias_uteis_de_ferias_em_tres_meases = 0;//resetando os dias de férias
                //Verificando se existe overlap 3 MESES
                if(strtotime($primeiro_dia_fora) <= strtotime($u_dia) && strtotime($ultimo_dia_fora) >= strtotime($tres_meses)) { 
                    $overlap_data_inicial_tres = max(strtotime($tres_meses),strtotime($primeiro_dia_fora)); //dia inicial do overlap  
                    $overlap_data_final = min(strtotime($u_dia),strtotime($ultimo_dia_fora)); //dia final do overlap
                    $dias_uteis_de_ferias_tres_meses =  minha_oni::contaDiasUteis( $overlap_data_inicial_tres, $overlap_data_final); //dias úteis no overlap
                    //Não considerar dias Sem desconto
                    if($fields['tipo_de_desconto'] !== 'Sem desconto'){
                        $this->onis[$user->display_name]['ferias_tres_meses'] += $dias_uteis_de_ferias_tres_meses;
                    }
                    //Verificando se existe overlap entre a data do filtro e a data das férias
                    if(strtotime($primeiro_dia_fora) <= strtotime($u_dia) && strtotime($ultimo_dia_fora) >= strtotime($p_dia)) {           
                        $overlap_data_inicial = max(strtotime($p_dia),strtotime($primeiro_dia_fora)); //dia inicial do overlap                 
                        $dias_uteis_de_ferias_no_periodo =  minha_oni::contaDiasUteis( $overlap_data_inicial, $overlap_data_final); //dias úteis no overlap
                        if($fields['tipo_de_desconto'] == 'Padrão'){
                            $this->onis[$user->display_name]['ferias_desconto_padrao'] += $dias_uteis_de_ferias_no_periodo;
                        }
                        if($fields['tipo_de_desconto'] == 'Desconto Total'){
                            $this->onis[$user->display_name]['ferias_desconto_total'] += $dias_uteis_de_ferias_no_periodo;
                        }

                    }
                }
               
            endwhile;endif; 
            wp_reset_query();
        
            // ADVERTÊNCIAS - puxando as advertências
            $args = array(
                'numberposts'	=> -1,
                'post_type'		=> 'advertencias',
                'post_status'   => 'publish',
                'meta_key'		=> 'oni',
                'meta_value'	=> $user->ID
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $fields = get_fields();
                $data_da_advertencia = str_replace('/', '-', $fields['data']);
                if(strtotime($data_da_advertencia) <= strtotime($u_dia) && strtotime($data_da_advertencia) >= strtotime($p_dia)) { 
                    $this->onis[$user->display_name]['advertencias']++;
                    $this->onis[$user->display_name]['explicacao_advertencias'][] = array(
                        'data' => $fields['data'],
                        'explicacao' => $fields['explicacao']          
                    );
                } 
            endwhile;endif;
        
        }
      
    }

    /**
    * Processando todos os pontos para gerar o volume de onions por oni e do sistema
    *
    * @return Array $this->folha atualizados com  
    *   [$user->display_name]
    *       [
    *       'onions_competencia'    => (int) Número de onions de competência  
    *       'onions_papeis'    => (int) Número de onions de papeis  
    *       'onions_de_ferias'    => (int) Número de onions que a pessoa deixou de ganhar com as férias  
    *       'onions'    => (int) Total de onions (competências+papéis-advertências-férias)
    *       ]
    */
    public function contaOnions($p_dia, $u_dia){
        $dias_uteis_periodo=  minha_oni::contaDiasUteis( strtotime($p_dia), strtotime($u_dia)); //dias úteis no período
        $equivalencia_pontos_onions = array(0 => 0, 1 => 1, 2 => 2, 3 => 4, 4 => 6, 5 => 8); //tabela de equivalência de pontos pra onions
        $equivalencia_guarda = 2; //Quantos pontos valem cada guarda
        $onions_trainee = get_field('onions_por_trainee', 'option');//onions por trainee
        $onions_socio = get_field('onions_por_socio', 'option');//onions por socio

        //loop por oni
        foreach($this->onis as $key => $oni){

            # FILTRAR STAGS E TRAINEES DEPOIS!!!
            if($oni['funcao'] == 'um_socio'){
                $this->onions_competencia =  $onions_socio;
                $this->onis[$key]['onions_competencia'] +=  $onions_socio;
            }else{
                //somando onions de competências do oni e do sistema
                foreach($oni['competencias'] as $competencia){
                    if($oni['funcao'] == 'um_oni'){
                        $this->onions_competencia +=  $equivalencia_pontos_onions[$competencia['pontos']];
                    }
                    $this->onis[$key]['onions_competencia'] +=  $equivalencia_pontos_onions[$competencia['pontos']];
                }
                if($oni['funcao'] == 'um_trainee'){
                    $this->onis[$key]['gap_trainee'] = $onions_trainee - $this->onis[$key]['onions_competencia'];
                }
                //somando onions de papel do oni e do sistema
                foreach($oni['guardas'] as $guarda){
                    if($guarda['com_rodinhas'] == false && $oni['funcao'] !== 'um_stag'){
                        $this->onions_papeis += $equivalencia_guarda*$guarda['percentual'];
                        $this->onis[$key]['onions_papeis'] += $equivalencia_guarda*$guarda['percentual'];
                    }
                }
                $this->onis[$key]['onions_competencia_dia'] = round(($this->onis[$key]['onions_competencia']/$dias_uteis_periodo) , 2);//onions de competência por dia
                $this->onis[$key]['onions_papeis_dia'] = round(($this->onis[$key]['onions_papeis']/$dias_uteis_periodo ), 2);//onions de papel por dia
                $this->onions_advertencias += $oni['advertencias']; //Somando onions de advertência do sistema
                //Lidando com as férias
                if($this->onis[$key]['ferias_tres_meses'] > 4){
                    $this->onis[$key]['onions_de_ferias'] =
                        round(0.33*($this->onis[$key]['onions_competencia_dia'] * $this->onis[$key]['ferias_desconto_padrao']) +
                        $this->onis[$key]['onions_papeis_dia'] * $this->onis[$key]['ferias_desconto_padrao'], 2) +
                        round(($this->onis[$key]['onions_competencia_dia'] * $this->onis[$key]['ferias_desconto_total']) +
                        $this->onis[$key]['onions_papeis_dia'] * $this->onis[$key]['ferias_desconto_total'], 2) 
                        ;
                            
                }else{
                    $this->onis[$key]['onions_de_ferias'] = 0;
                }

                if($oni['funcao'] == 'um_oni'){
                    $this->onis[$key]['onions'] = $this->onis[$key]['onions_competencia']+$this->onis[$key]['onions_papeis_dia']-$this->onis[$key]['onions_de_ferias']-$this->onis[$key]['advertencias'];// Onions do oni
                }

                if($oni['funcao'] == 'um_trainee'){
                    $this->onis[$key]['onions'] = $onions_trainee+$this->onis[$key]['onions_papeis_dia']-$this->onis[$key]['onions_de_ferias']-$this->onis[$key]['advertencias'];// Onions do oni
                }
                
            }
            
            $this->onions_no_sistema += $this->onis[$key]['onions'];// Onions do sistema
            
        }      
       
    }

    /**
    * Cruza os dados financeiros com os Onis para gerar a folha
    *
    * @return Array $this->onis atualizados com  
    *   [$user->display_name]
    *       [
    *       'reembolsos'    => (int) Valor dos reembolsos
    *       'remuneracao'    => (int) Número de onions de competência  
    *       ]
    */
    public function fechaFolha(){
        //VALOR DO ONION - definindo o valor do Onion
        $this->valor_do_onion = round($this->budget_folha/$this->onions_no_sistema,2);

        foreach($this->onis as $key => $oni){
            // REEMBOLSOS - buscando o reembolso pelo id do granatum
            $id_do_granatum = get_field('id_do_granatum', 'user_'.$oni['ID']); //id do usuário no granatum
            if($id_do_granatum){
                $ir = array_search($id_do_granatum, array_column($this->reembolsos_onis, 'id'));
                $this->onis[$key]['reembolsos'] = $this->reembolsos_onis[$ir]['valor'];
                
            }else{
                //cadastra o alerta caso não tenha ID cadastrado
                $this->alerts[] = $key." não tem ID do granatum cadastrada no sistema";
            }

            # FILTRAR STAGS E TRAINEES DEPOIS!!!

            //REMUNERAÇÃO - Colocando os valores por oni
            $this->onis[$key]['remuneracao'] = $this->onis[$key]['reembolsos']+($this->onis[$key]['onions']*$this->valor_do_onion);
            
        }
    }
}

//Criando o objeto
$processa_folha = new processa_folha;

goto a;





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

a:
?>