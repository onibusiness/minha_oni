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
        add_action('init', array($this,'initCPT'));
        add_action('init', array($this,'criarPrismas')); 
        add_action('acf/save_post', array($this, 'consolidarOnionUpEvolucao'));
    }
    public function initCPT(){
        cpt::adicionarCustomPostType($this->nome_singular,$this->nome_plural, $this->post_slug);
    }    


    //Função para criar a taxonomia Prismas
    public function criarPrismas(){
 
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


}

//Criando o objeto
$lentes = new lentes;
?>