<?php
/*
* Montando as operação no painel adminsitrativo do wordpress
* 
*/

class adminpannel{

    //disparando a classe
    public function __construct(){
        add_action( 'wp_dashboard_setup', array($this,'exibeFerias') );
        add_action( 'wp_dashboard_setup', array($this,'criaClickup') );
        add_action( 'admin_init', array($this,'removerWidgets') ); 
        add_action( 'admin_action_criar_missoes_clickup', array($this,'criarMissoesClickup') ); 
    }
    /**
    * Remove os widgets padrões do wordpress
    *
    */
    function removerWidgets() {
     
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
        
    }
    

    /**
    * Cadastra o widget de pedidos de férias
    *
    */
    function exibeFerias() {
        wp_add_dashboard_widget(
            'pedidos_de_ferias', // Widget slug.
            'Pedidos de férias', // Title.
            array($this,'widgetPedidosFerias') // Display function.
        );
    }
    /**
    * Puxa o modelo do widget de pedidos de férias
    *
    */
    function widgetPedidosFerias() {

        include(get_stylesheet_directory() . '/template-parts/widget-admin-ferias.php');
    }

    
    /**
    * Cadastra o widget de criação de missões
    *
    */
    function criaClickup() {
        wp_add_dashboard_widget(
            'cadastra_missoes', // Widget slug.
            'Cadastrar missões para todos os onis no clickup', // Title.
            array($this,'widgetCriaClickup'), // Display function.
        );
    }
    /**
    * Puxa o modelo do widget de criação de missões de missões
    *
    */
    function widgetCriaClickup() {

        include(get_stylesheet_directory() . '/template-parts/widget-cria-clickup.php');
    }

    /**
    * Gerencia a fila de requisições ao clickup
    *
    */
    function filaCriarMissoesClickup() {

    }



    /**
    * Motor de criação de missões 
    *
    */
    function criarMissoesClickup() {
        $assignees = array();
        $onis = get_users();
        foreach($onis as $oni){
            $id_do_clickup = get_field('informacoes_gerais', 'user_'.$oni->ID);
            $id_do_clickup = $id_do_clickup ['id_do_clickup'] ;
            $assignees[] = $id_do_clickup;
        }
        //date format YYY-MM-DD
        $data_de_fim =  DateTime::createFromFormat('Y-m-d',  $_POST['date'] );
        $data_de_fim = $data_de_fim->getTimestamp();
        $horas = $_POST['h_planejada'];
        $assignees = array_filter($assignees);
        foreach($assignees as $assignee){

                $task_criada = clickup::$cliente->request('POST','list/11498294/task',
                array(
                    'json' => array(
                        'name' => $_POST['missao'],
                        'assignees' => [$assignee],
                        'due_date' => $data_de_fim.'000',
                        'due_date_time' => false,
                        'time_estimate' => strval($horas*60*60*1000)
                    
                    )
                )
            );
        }
        wp_redirect( $_SERVER['HTTP_REFERER'] );
    exit();
    }
}

//Criando o objeto
$adminpannel = new adminpannel;
?>