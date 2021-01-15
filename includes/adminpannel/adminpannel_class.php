<?php
/*
* Montando as operação no painel adminsitrativo do wordpress
* 
*/

class adminpannel{

    //disparando a classe
    public function __construct(){
        add_action( 'wp_dashboard_setup', array($this,'exibeFerias') );
        add_action( 'admin_init', array($this,'removerWidgets') ); 

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
}

//Criando o objeto
$adminpannel = new adminpannel;
?>