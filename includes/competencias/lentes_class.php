<?php
/*
* Lentes
* Cria um post type chamado lentes e todas as suas configurações no ACF
* Configura a taxonomia Prismas para organizar tudo
*/

class lentes{

    //variaveis
    private $nome_singular = 'Lente';
    private $nome_plural = 'Lentes';
    private $post_slug = 'lente';


    //disparando a classe
    public function __construct(){

        add_action('init', array($this,'adicionar_custom_post_type')); 
        add_action('init', array($this,'criar_prismas')); 
        add_action('init', array($this,'check_flush_rewrite_rules')); 

    }

    //Adicionando o custom post type
    public function adicionar_custom_post_type(){
            $labels = array(
            'name'               => ucwords($this->nome_singular),
            'nome_singular'      => ucwords($this->nome_singular),
            'menu_name'          => ucwords($this->nome_plural),
            'name_admin_bar'     => ucwords($this->nome_singular),
            'add_new'            => ucwords($this->nome_singular),
            'add_new_item'       => 'Add New ' . ucwords($this->nome_singular),
            'new_item'           => 'New ' . ucwords($this->nome_singular),
            'edit_item'          => 'Edit ' . ucwords($this->nome_singular),
            'view_item'          => 'View ' . ucwords($this->nome_plural),
            'all_items'          => 'All ' . ucwords($this->nome_plural),
            'search_items'       => 'Search ' . ucwords($this->nome_plural),
            'parent_item_colon'  => 'Parent ' . ucwords($this->nome_plural) . ':', 
            'not_found'          => 'No ' . ucwords($this->nome_plural) . ' found.', 
            'not_found_in_trash' => 'No ' . ucwords($this->nome_plural) . ' found in Trash.',
        );
        
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','editor','thumbnail'), 
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-format-status',
            'taxonomies'          => array( 'prismas' ),
        );
        
        
        register_post_type($this->post_slug, $args);
        
    }

 

    //Função para criar a taxonomia Prismas
    public function criar_prismas(){
 
        $labels = array(
            'name' => _x( 'Prismas', 'taxonomy general name' ),
            'singular_name' => _x( 'Prisma', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Prismas' ),
            'all_items' => __( 'All Prismas' ),
            'parent_item' => __( 'Parent Prisma' ),
            'parent_item_colon' => __( 'Parent Prisma:' ),
            'edit_item' => __( 'Edit Prisma' ), 
            'update_item' => __( 'Update Prisma' ),
            'add_new_item' => __( 'Add New Prisma' ),
            'new_item_name' => __( 'New Prisma Name' ),
            'menu_name' => __( 'Prismas' ),
        );    
        
        
        register_taxonomy('prisma',array($this->post_slug), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'prisma' ),
        ));
        
    }

    //Função pronta que dá um refresh nos permalinks
    public function check_flush_rewrite_rules(){
        $has_been_flushed = get_option($this->post_slug . '_flush_rewrite_rules');
        //if we haven't flushed re-write rules, flush them (should be triggered only once)
        if($has_been_flushed != true){
            flush_rewrite_rules(true);
            update_option($this->post_slug . '_flush_rewrite_rules', true);
        }
    }

}

//Criando o objeto
$lentes = new lentes;
?>