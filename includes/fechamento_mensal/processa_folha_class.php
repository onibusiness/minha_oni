<?php

/*
* Faz o processamento da folha
*
*/
class processa_folha{
    public $p_dia;//primeiro dia da requisição
    public $u_dia;//ultimo dia da requisicao
    public $reembolsos_onis = [];// reembolsos por oni
    public $centros_custo_oni = [];//centos de custo da Oni
    public $categorias_faturamento = array();//categorias de faturamento dos projetos
    public $receitas = 0; //valor das receitas do período
    public $lista_receitas = []; //lista de receitas no período
    public $despesas = 0; //despesas do período
    public $custos_de_projeto = 0; //valor custos de projeto do período
    public $lista_custos_de_projeto = []; //lista de custos de projeto do período
    public $budget_folha = 0;// budget da folha
    public $onis; //array de onis 
    public $onions_lentes = 0; //numero de onions de lentes no sistema
    public $onions_competencia = 0; //numero de onions de competencia no sistema
    public $onions_papeis = 0; //numero de onions de papeis no sistema
    public $onions_subsidiados = 0; //numero de onions que foram complementados para os trainees
    public $onions_advertencias = 0; //numero de onions de advertencias tomadas no sistema
    public $onions_ferias= 0; //numero de onions redistribuidos por férias
    public $onions_no_sistema = 0; //numero de onions no sistema
    public $folha; //array com a folha fechada por Oni    
    public $valor_do_onion; //valor do onion   
    public $projetos; //projetos ativos e suas guardas   
    
    
    
    public $alerts = array(); //guardando todos os alerts da requisição
 

    //disparando a classe
    public function __construct(){
        //inserindo todos os custom post types        
        require_once('granatum_class.php');
        //setando as datas
        $this->setaDatas($granatum->p_dia,$granatum->u_dia);
        //criando o array reembolsos
        $this->setaReembolsos($granatum->categorias);
        //montandos os centros de custo
        $this->montaCentroCustoOni($granatum->centros_custo_lucro);
        //pegando as categorias de faturamento
        $this->pegaCategoriasFaturamento($granatum->categorias);
        // processa o financeiro
        $this->processaFinanceiro($granatum->centros_custo_lucro, $granatum->lancamentos_cartao, $granatum->lancamentos_conta, $this->p_dia, $this->u_dia );

        // monta o array dos onis
        $this->montaOnis( $this->p_dia, $this->u_dia);

        // conta os Onions do sistema
        $this->contaOnions($this->p_dia, $this->u_dia);

        // fecha a folha
        $this->fechaFolha();

        //revisando os projetos e papeis
        $this->revisaProjetos($granatum->p_dia,$granatum->u_dia);
        
        // consolida a folha
        $this->consolidaFolha( $granatum->u_dia);
    }

    /**
    * Setando as datas
    *
    * @return Mixed  com p_dia e U_dia setados
    * 
    */
    public function setaDatas($p_dia,$u_dia){
        $this->p_dia = $p_dia;
        $this->u_dia = $u_dia;
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
    * @param Array $centros_custo_lucro com todos os centros de custo do granatum
    * @param Array $lancamentos_cartao | Json decoded com a resposta de lançamentos de cartão vindo do granatum 
    * @param Array $lancamentos_conta | Json decoded com a resposta de lançamentos de contas vindo do granatum
    * @param String $p_dia | 'Y-m-d' Com o primeiro dia do período
    * @param String $u_dia | 'Y-m-d' Com o último dia do período  
    *     
    */
    public function processaFinanceiro($centros_custo_lucro,$lancamentos_cartao, $lancamentos_conta,$p_dia, $u_dia ){
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
                                    $this->lista_receitas[] = $lancamento->descricao." : R$ ".number_format($lancamento->valor, 2, ',','.');
                                };
                            elseif($valor < 0 ):
                                if($u_dia_date >= $data_vencimento ){
                                    $this->despesas += $lancamento->valor;
                                }
                                
                                if(!in_array($lancamento->centro_custo_lucro_id, $this->centros_custo_oni) && ($lancamento->categoria_id != '229974')){
                    
                    
                                    $this->custos_de_projeto += $lancamento->valor;
                                    $centro_custo_lancamento = array_search($lancamento->centro_custo_lucro_id,array_column($centros_custo_lucro, "id"));
                                    $this->lista_custos_de_projeto[] = $centros_custo_lucro[$centro_custo_lancamento]['descricao']." - ". $lancamento->descricao." : R$ ".number_format($lancamento->valor, 2, ',','.');


                              
                                }
                    
                            
                            endif;
                            if(in_array($lancamento->categoria_id, array_column($this->reembolsos_onis, 'id'))){
                                $id_reembolso = array_search($lancamento->categoria_id , array_column($this->reembolsos_onis, 'id')); 
                                $this->reembolsos_onis[$id_reembolso]['valor'] += $lancamento->valor;
                                $this->reembolsos_onis[$id_reembolso]['gastos'][] = $lancamento->descricao." : R$ ".number_format(-$lancamento->valor, 2, ',','.');
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
    *       'lentes'    => (array) Lentes até a data
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
                'lentes' => array(),
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
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'post_type'		=> 'competencias',
                'post_status'   => 'publish'
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $this->onis[$user->display_name]['competencias'][get_the_title()]['competencia'] = get_the_title();
                $this->onis[$user->display_name]['competencias'][get_the_title()]['pontos'] = 0;
            endwhile;endif;
            wp_reset_query();

            // COMPETENCIAS - lendo todas as evoluções e montando competencias
            $args = array(
                'posts_per_page' => -1,
                'no_found_rows' => true,
                'post_type'		=> 'evolucoes',
                'post_status'   => 'publish',
                'meta_key'		=> 'oni',
                'meta_value'	=> $user->ID
            );
            $the_query = new WP_Query( $args );
            
            if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                $lente = null;
                $fields = get_fields();
                $competencia = get_field('competencia');
                $competencia = get_the_title($competencia);
        

                $lente = get_field('lente');
        
                //preenchendo as lentes e competencia
                if($lente){
                    $lente = get_the_title($lente);
                    $this->onis[$user->display_name]['lentes'][] = array('lente' => $lente);
                    
                }else{
                    $this->onis[$user->display_name]['competencias'][$competencia]['pontos'] += $fields['nivel'];
                }
                //Checkando se a evolução foi nesse mês
                $data_evolucao = str_replace('/', '-', $fields['data']);
                if((strtotime($data_evolucao) >= strtotime($p_dia)) && (strtotime($data_evolucao) <= strtotime($u_dia))){
                    if($lente ){
                        
                    }else{
                        $this->onis[$user->display_name]['competencias'][$competencia]['onion_up'] = 'true';
                    }
                }
            endwhile;endif;
            wp_reset_query();

            // GUARDAS - lendo as guardas
            $args = array(
                'posts_per_page' => -1,
                'no_found_rows' => true,
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
                'posts_per_page' => -1,
                'no_found_rows' => true,
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
    *       'onions_lentes'    => (int) Número de onions de lentes  
    *       'onions_papeis'    => (int) Número de onions de papeis  
    *       'onions_de_ferias'    => (int) Número de onions que a pessoa deixou de ganhar com as férias  
    *       'onions'    => (int) Total de onions (competências+papéis-advertências-férias)
    *       ]
    */
    public function contaOnions($p_dia, $u_dia){
        $dias_uteis_periodo=  minha_oni::contaDiasUteis( strtotime($p_dia), strtotime($u_dia)); //dias úteis no período
        $equivalencia_pontos_onions = array(0 => 0, 1 => 1, 2 => 2, 3 => 4, 4 => 6, 5 => 8); //tabela de equivalência de pontos pra onions
        $equivalencia_guarda = 3; //Quantos pontos valem cada guarda
        $equivalencia_lente = 2; //Quantos pontos valem cada lente
        $onions_trainee = get_field('onions_por_trainee', 'option');//onions por trainee
        $onions_socio = get_field('onions_por_socio', 'option');//onions por socio

        //loop por oni
        foreach($this->onis as $key => $oni){
            $this->onis[$key]['onions_papeis'] = 0;
            //Onions do sócio
            if($oni['funcao'] == 'um_socio'){
                $this->onions_competencia +=  $onions_socio;
                $this->onis[$key]['onions_competencia'] +=  $onions_socio;
            //Onions dos Onis e trainees
            }else{
                //somando onions de competências do oni e do sistema

                foreach($oni['competencias'] as $competencia){
                    $this->onis[$key]['onions_competencia'] +=  $equivalencia_pontos_onions[$competencia['pontos']];
                    if($oni['funcao'] == 'um_oni' || $oni['funcao'] == 'um_trainee'){
                        $this->onions_competencia +=  $equivalencia_pontos_onions[$competencia['pontos']];
                    }
                    
                }
                //somando onions de lente do oni e do sistema
                foreach($oni['lentes'] as $lente){

                    $this->onis[$key]['onions_lentes'] +=  $equivalencia_lente;
                    if($oni['funcao'] == 'um_oni' || $oni['funcao'] == 'um_trainee' ){
                        $this->onions_lentes +=  $equivalencia_lente;
                    }
                    
                }
                //Verifica quantos Onions falta para o trainee alcancar o piso e joga no sistema
                if($oni['funcao'] == 'um_trainee'){
                    $this->onis[$key]['gap_trainee'] = $onions_trainee - $this->onis[$key]['onions_competencia'] - $this->onis[$key]['onions_lentes'];
                    //Se o gap ainda existir
                    if($this->onis[$key]['gap_trainee'] > 0){
                        $this->onions_subsidiados +=   $this->onis[$key]['gap_trainee'] ;
                    }else{
                        //Estou bloqueando o fechamento da folha aqui e fazendo o sócio dar o up no trainee
                        $this->alerts[] = $key." acabou de evoluir de trainee para oni =). Troque o o papel no sistema antes de fechar a folha.";
                    }
                    
                }
                //somando onions de papel do oni e do sistema
                foreach($oni['guardas'] as $guarda){
                    //Stags e guardas com rodinhas não contam
           
                  
                    if($guarda['com_rodinhas'] == false && $oni['funcao'] !== 'um_stag'){

                        $this->onions_papeis += $equivalencia_guarda*$guarda['percentual'];
                        $this->onis[$key]['onions_papeis'] += $equivalencia_guarda*$guarda['percentual'];
                    }
                }
                $this->onis[$key]['onions_competencia_dia'] = round((($this->onis[$key]['onions_competencia']+ $this->onis[$key]['gap_trainee'])/$dias_uteis_periodo) , 2);//onions de competência por dia
                $this->onis[$key]['onions_lente_dia'] = round((($this->onis[$key]['onions_lentes']+ $this->onis[$key]['gap_trainee'])/$dias_uteis_periodo) , 2);//onions de competência por dia
                $this->onis[$key]['onions_papeis_dia'] = round(($this->onis[$key]['onions_papeis']/$dias_uteis_periodo ), 2);//onions de papel por dia
                $this->onions_advertencias += $oni['advertencias']; //Somando onions de advertência do sistema
                //Lidando com as férias, de forma que só compute férias a partir do dia setado
                $dias_ferias_pre_desconto =  get_field('dias_ferias_pre_desconto', 'option');
                if($this->onis[$key]['ferias_tres_meses'] > $dias_ferias_pre_desconto){
                    $this->onis[$key]['onions_de_ferias'] =
                        round(0.33*($this->onis[$key]['onions_competencia_dia'] * $this->onis[$key]['ferias_desconto_padrao']) +
                        ($this->onis[$key]['onions_papeis_dia'] * $this->onis[$key]['ferias_desconto_padrao']) +
                        ($this->onis[$key]['onions_lente_dia'] * $this->onis[$key]['ferias_desconto_padrao']), 2) +
                        round(($this->onis[$key]['onions_competencia_dia'] * $this->onis[$key]['ferias_desconto_total']) +
                        ($this->onis[$key]['onions_papeis_dia'] * $this->onis[$key]['ferias_desconto_total']) +
                        ($this->onis[$key]['onions_lente_dia'] * $this->onis[$key]['ferias_desconto_padrao']), 2) 
                        ;
                            
                }else{
                    $this->onis[$key]['onions_de_ferias'] = 0;
                }

                if($oni['funcao'] == 'um_oni'){
                    $this->onis[$key]['onions'] = $this->onis[$key]['onions_competencia']+$this->onis[$key]['onions_papeis']+$this->onis[$key]['onions_lentes']-$this->onis[$key]['onions_de_ferias']-$this->onis[$key]['advertencias'];// Onions do oni
                }

                if($oni['funcao'] == 'um_trainee'){
                    $this->onis[$key]['onions'] = $onions_trainee+$this->onis[$key]['onions_papeis']-$this->onis[$key]['onions_de_ferias']-$this->onis[$key]['advertencias'];// Onions do trainee
                }
                
            }
            if($oni['funcao'] == 'um_socio'){
                $this->onis[$key]['onions'] = $this->onis[$key]['onions_competencia'];// Onions do sócio
            }
            if($oni['funcao'] !== 'um_stag'){
                $this->onions_no_sistema += $this->onis[$key]['onions'];// Onions do sistema
            }
            
        }      
       
    }

    /**
    * Cruza os dados financeiros com os Onis para gerar a folha
    *
    * @return Array $this->onis atualizados com  
    *   [$user->display_name]
    *       [
    *       'reembolsos'    => (int) Valor dos reembolsos
    *       'descricao_reembolsos'    => (array) strings com a descrição dos reembolsos    
    *       'remuneracao'    => (int) Número de onions de competência  
    *       ]
    */
    public function fechaFolha(){
        //VALOR DO ONION - definindo o valor do Onion
        $this->valor_do_onion = round($this->budget_folha/$this->onions_no_sistema,2);

        foreach($this->onis as $key => $oni){
            // REEMBOLSOS - buscando o reembolso pelo id do granatum
            $id_do_granatum = get_field('informacoes_gerais', 'user_'.$oni['ID']); //id do usuário no granatum
            $id_do_granatum = $id_do_granatum ['id_do_granatum'] ;

            if($id_do_granatum){
                $ir = array_search($id_do_granatum, array_column($this->reembolsos_onis, 'id'));
                if($ir !== false){
                    $this->onis[$key]['reembolsos'] = -$this->reembolsos_onis[$ir]['valor'];
                    $this->onis[$key]['descricao_reembolsos'] = $this->reembolsos_onis[$ir]['gastos'];
                }
            }else{
                //cadastra o alerta caso não tenha ID cadastrado
                $this->alerts[] = $key." não tem ID do granatum cadastrada no sistema";
            }

            //REMUNERAÇÃO - Colocando os valores por sócios, oni e trainees
            $this->onis[$key]['remuneracao'] = ($this->onis[$key]['onions']*$this->valor_do_onion)+$this->onis[$key]['reembolsos'];

            if($oni['funcao'] == 'um_stag'){
                $remuneracao_stag = get_field('remuneracao_stag', 'option');//valor da remuneração do stag
                $this->onis[$key]['remuneracao'] = $remuneracao_stag;
            }
            if($oni['funcao'] == 'um_administrativo'){
                $remuneracao_admin_fin = get_field('remuneracao_admin_fin', 'option');//valor da remuneração do stag
                $this->onis[$key]['remuneracao'] = $remuneracao_admin_fin;
            }
            
        }
    }

 /**
    * Revisa os projetos cadastrados e seus papéis
    *
    * @return Mixed warnings de projeto sem papéis
    *     
    */
    public function revisaProjetos($p_dia, $u_dia){


        // GUARDAS - lendo as guardas
        $args = array(
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'post_type'		=> 'papeis',
            'post_status'   => 'publish',
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
            $fields = get_fields();
            //Pegando as datas da guarda
            $data_de_inicio_projeto = str_replace('/', '-', $fields['data_de_inicio']);
            $data_de_termino_projeto = str_replace('/', '-', $fields['data_de_terminio']);
            $projeto = get_field('projeto', $fields['projeto']->ID );
            //Verificando se existe overlap entre a data do filtro e a data da guarda
            if(strtotime($data_de_inicio_projeto) <= strtotime($u_dia) && strtotime($data_de_termino_projeto) >= strtotime($p_dia)) {           
                $this->projetos[$projeto][$fields['papel']][] = $fields['oni'];
            }
        endwhile;endif;
        wp_reset_query();
        ksort($this->projetos);
    
    }



    /**
    * Consolida toda a folha
    *
    * @return Mixed Criando os posts de fechamento da Oni e de pagamento por oni
    *     
    */
    public function consolidaFolha($u_dia){
        if(count($this->alerts)< 0){
            # passar um alerta via Ajax de que existem problemas na folha
            echo "EXISTEM ALERTAS IMPEDINDO O FECHAMENTO";
            return;
        }else{
    
                delete_transient('onis');
                delete_transient('u_dia');
                set_transient('onis',json_encode($this->onis));
                set_transient('u_dia',$u_dia);

        
        }
    }

    
}

//Criando o objeto
$processa_folha = new processa_folha;

?>