<?php
/*
* Minha Oni
* Classe que controla tudo que acontece no tema
*/

class minha_oni{

    //variaveis
    public $diretorio_tema = '';

    //disparando a classe
    public function __construct(){

        $this->setaDiretorioTema();

        //criando as opções para o menu administrativo    
        require_once($this->diretorio_tema.'/includes/adminpannel/adminpannel_class.php');  

        //inserindo todos os custom post types      
        require_once($this->diretorio_tema.'/includes/comunicados/comunicados_class.php');  
        require_once($this->diretorio_tema.'/includes/tutoriais/tutoriais_class.php');
        require_once($this->diretorio_tema.'/includes/competencias/competencias_class.php');
        require_once($this->diretorio_tema.'/includes/competencias/lentes_class.php');
        require_once($this->diretorio_tema.'/includes/evidencias/evidencias_class.php');
        require_once($this->diretorio_tema.'/includes/evidencias/processa_evidencias_class.php');
        require_once($this->diretorio_tema.'/includes/competencias/processa_competencias_class.php');
        require_once($this->diretorio_tema.'/includes/ferramentas/ferramentas_class.php');
        require_once($this->diretorio_tema.'/includes/fechamento_mensal/fechamento_mensal_class.php');
        require_once($this->diretorio_tema.'/includes/ferias/ferias_class.php');
        require_once($this->diretorio_tema.'/includes/papeis/papeis_class.php');
        require_once($this->diretorio_tema.'/includes/advertencias/advertencias_class.php');
        require_once($this->diretorio_tema.'/includes/historico/historico_class.php');
        require_once($this->diretorio_tema.'/includes/projetos/projetos_class.php');
        require_once($this->diretorio_tema.'/includes/user_oni/user_oni_class.php');
        require_once($this->diretorio_tema.'/includes/projetos/feedbacks_class.php');
        require_once($this->diretorio_tema.'/includes/integracoes/integracoes_class.php');
        require_once($this->diretorio_tema.'/includes/pipefy/pipefy_class.php');
        require_once($this->diretorio_tema.'/includes/avaliacoes/avaliacoes_class.php');
        require_once($this->diretorio_tema.'/includes/avaliacoes/processa_avaliacoes_class.php');

        //Pegando as customizações do acf 
        require_once($this->diretorio_tema.'/includes/acf/acf_class.php');

     

        //acrescentando o menu
        add_action('init', array($this,'adicionaMenu')); 

        //Ajustando o carregamento dos scripts e estilos
        add_action('wp_enqueue_scripts', array($this,'ajustaRequisicoes')); 

        //Removendo suporte a emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');

        //Sobrescrevendo o redirect do login
        add_action( 'login_form' ,  array($this,'redirecionaLogin'));

        //Criando o endpoint
        add_action( 'rest_api_init', array($this,'criarWebhook'));

        //Fazendo uma função temporária para conseguir importar os pagamentos a  partir do json gerado pelo Bi
        //$this->puxaPagamentosAntigosBI();

    }

    public function puxaPagamentosAntigosBI(){
        $pagamentos = file_get_contents($this->diretorio_tema.'/includes/pagamentos.json');
        $pagamentos = json_decode($pagamentos);
        foreach($pagamentos as $title => $pagamento){
            $data_do_pagamento = strtotime( $pagamento->data."-01");
 
            $arg= array(
                'search' => $pagamento->oni, // or login or nicename in this example
                'search_fields' => array('display_name')
              );
              $oni = '';
              $users = new WP_User_Query($arg);
              foreach($users->results as $user){
                  $oni = $user;
              }
            
            $args = array (
                'post_type'              => array( 'pagamentos' ),
                'post_status'            => array( 'publish' ),
                'nopaging'               => true,
                's' => $title
            );
            $pagamentosSalvos = new WP_Query( $args );
   
            //Se tiver posts salvos ele passa batido
            if ( $pagamentosSalvos->have_posts() ) {
                    #passar via Ajax
    
            } else {
                
                $my_post = array(
                    'post_title' => $title,
                    'post_status' => 'publish',
                    'post_type' => 'pagamentos',
                );
                
                $post_id = wp_insert_post($my_post);
                update_field('data', $data_do_pagamento , $post_id);
                update_field('oni', $oni, $post_id);
                //update_field('cargo', $oni['funcao'], $post_id);
                update_field('competencias', $pagamento->competencias, $post_id);
                //update_field('lentes', $oni['lentes'], $post_id);
                //update_field('guardas', $oni['guardas'], $post_id);
                update_field('ferias_desconto_padrao', $pagamento->dias_de_ausencia, $post_id);
                //update_field('ferias_desconto_total', $oni['ferias_desconto_total'], $post_id);
                update_field('ferias_tres_meses', $pagamento->dias_de_ausencias_nos_3_meses_anteriores, $post_id);
                //update_field('advertencias', $oni['advertencias'], $post_id);                       
                update_field('onions_competencia', $pagamento->onions_de_competencias, $post_id);
                //update_field('onions_lentes', $oni['onions_lentes'], $post_id);
                update_field('onions_papeis', $pagamento->onions_de_envolvimento, $post_id);
                update_field('onions_ferias', $pagamento->onions_descontados, $post_id);
                update_field('onions', $pagamento->total_de_onions, $post_id);
                update_field('reembolsos', $pagamento->valor_reembolsos, $post_id);
      
                update_field('descricao_reembolsos', implode('</br>',$pagamento->reembolsos), $post_id);
     
                update_field('remuneracao', $pagamento->remuneracao, $post_id);
                
            }
        }
     
    }

    public function redirecionaLogin(){

        global $redirect_to;
        $redirect_to = get_home_url();

    }

    //Setando o diretório do tema
    public function setaDiretorioTema(){
        $this->diretorio_tema = get_stylesheet_directory();
    }



    //Adicionando os menus
    public function adicionaMenu(){
        register_nav_menus(
            array(
              'menu-geral' => __( 'Geral' ),
              'menu-onis' => __( 'Onis' )
            )
          );

    }


    //Mexendo na ordem de requisição dos estilos e scripts
    public function ajustaRequisicoes(){
        wp_deregister_script( 'wp-embed' );
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);

        // Deregister ACF Form style
        wp_deregister_style('acf-global');
        wp_deregister_style('acf-input');
        // Avoid dependency conflict
        wp_register_style('acf-global', false);
        wp_register_style('acf-input', false);
    }



    
    /**
     * Conta os dias úteis entre duas datas.
     *
     * @param date $date1 Data inicial
     * @param date $date2 Data final
     * @param bol $workSat Trabalhar no sábado ou não
     * @return Int  com o número de dias
     */
    public function contaDiasUteis($date1, $date2, $workSat = FALSE) {
        if (!defined('SATURDAY')) define('SATURDAY', 6);
        if (!defined('SUNDAY')) define('SUNDAY', 0);
        $ano = date('Y', $date1);
        $pascoa = easter_date($ano);
        $dia_pascoa = date('j', $pascoa);
        $mes_pascoa = date('n', $pascoa);
        $carnaval1 = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano);//2ºferia Carnaval
        $carnaval2 =  mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano);//3ºferia Carnaval	
        $carnaval3 =  mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 46,  $ano);//4ºferia Carnaval	
        $sexta_santa = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano);//6ºfeira Santa  
        $corpus = mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano);//Corpus Cirist
        $data_pascoa = date('m-d', $pascoa);
        $data_carnaval1 = date('m-d', $carnaval1);
        $data_carnaval2 = date('m-d', $carnaval2);
        $data_carnaval3 = date('m-d', $carnaval3);
        $data_sexta_santa = date('m-d', $sexta_santa);
        $data_corpus = date('m-d', $corpus);
        $halfdays = array($data_carnaval3);
        $publicHolidays = array('01-01', '04-21', '05-01', '09-07','10-12','11-02','11-15', '12-25', $data_pascoa, $data_carnaval1, $data_carnaval2, $data_sexta_santa, $data_sexta_santa);
        $workdays = 0;
        for ($i = $date1; $i <= $date2; $i = strtotime("+1 day", $i)) {
            $day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
            $mmgg = date('m-d', $i);
        
            if ($day != SUNDAY &&
                !in_array($mmgg, $publicHolidays) &&
                !($day == SATURDAY && $workSat == FALSE)) {
                if(in_array($mmgg, $halfdays)){
                    $workdays += 0.5;
                }else{
                    $workdays++;
                }     
            }
        }
        return round( $workdays, 2);
    }
    
    /**
     * Registra os seguintes endpoints na API REST
     *
     * https://minha.oni.com.br/wp-json/apioni/v1/alteraprojeto/
     * 
     */
    public function criarWebhook(){
     
        register_rest_route( 'apioni/v1', '/alteraprojeto', array(
            'methods'  => [ 'POST', 'GET' ], 
            'callback' =>  array($this, 'escutaAlteraProjeto'),
        ) );
    

    }
    public function escutaAlteraProjeto( $request ) {
        $tables_alteradas = pipefy::escutaAlteraProjeto($request);
        $table_records_frentes = pipefy::puxaDaTabela($tables_alteradas['frentes_alteradas']);
        set_transient('tables', $table_records_frentes);

        $card_projeto = pipefy::puxaCard($tables_alteradas['projeto_alterado'][0]);
        set_transient('projetos', $card_projeto);

        if(is_array($card_projeto['data']['card']['fields'])){
            $fields =  array_column($card_projeto['data']['card']['fields'], 'name');
            $id_projeto_alterado = array_search('Cadastro do projeto', $fields);
            $id_table_projeto = $card_projeto['data']['card']['fields'][$id_projeto_alterado]['array_value'];
            set_transient('id_table_projeto', $id_table_projeto);
          }

        $table_record_projeto = pipefy::puxaDaTabela($id_table_projeto);
        set_transient('table_record_projeto', $table_record_projeto);
        //Pegando o nome do projeto
        $id_projeto = array_search( array( 'id'=> "nome_do_projeto","label" =>"Nome do projeto") , array_column( $table_record_projeto[0]['data']['table_record']['record_fields'], 'field' ));
        $nome_projeto = $table_record_projeto[0]['data']['table_record']['record_fields'][$id_projeto]['value'];
        integracoes::cadastraIdPipefy($id_table_projeto[0],$nome_projeto);

        //Cadastrando o guardião de método
        papeis::cadastraPapelMetodo($table_records_frentes);
 
    }

}

//Criando o objeto
$minha_oni = new minha_oni;
?>